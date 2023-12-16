<?php

namespace App\Http\Controllers;

use App\Interfaces\DetalleVentaRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\VentaRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VentaController extends Controller
{
    private $repository;
    private $repositoryDetalle;
    private $repositoryProd;

    public function __construct(
        VentaRepositoryInterface $repository,
        DetalleVentaRepositoryInterface $repositoryDetalle,
        ProductRepositoryInterface $repositoryProd
    ) {
        $this->repository = $repository;
        $this->repositoryDetalle = $repositoryDetalle;
        $this->repositoryProd = $repositoryProd;
    }

    public function redirectPageVentas()
    {
        return Inertia::render('Ventas/Index');
    }

    public function listAll()
    {
        return $this->repository->all(['*'], ['detalleVentas', 'detalleVentas.product', 'detalleVentas.product.productsTipo']);
    }

    public function create(Request $request)
    {
        $request['responsable'] = Auth::user()->email;
        $venta = $this->repository->create($request->except('detalle_venta'));
        $detalle = $request['detalle_venta'];
        foreach ($detalle as $det) {
            $det['id_venta'] = $venta->id_venta;
            $this->repositoryDetalle->create($det);
            $producto = $this->repositoryProd->findById($det['id_prod']);
            $stockactual = $producto->stock;
            $descontando = $stockactual - $det['cantidad'];
            $this->repositoryProd->update($det['id_prod'], ["stock" => $descontando]);
        }
        $this->ejecutarfacturacion($venta->id_venta);
        return 'ok';
    }
    public function update($id, Request $request)
    {
        return $this->repository->update($id, $request->all());
    }
    public function delete($id)
    {
        return $this->repository->update($id, ["enable" => 0]);
    }



    public  function ejecutarfacturacion($id_venta)
    {

        $productosvnt = $this->repository->findById($id_venta, ['*'], ['detalleVentas', 'detalleVentas.product', 'detalleVentas.product.productsTipo']);

        $arrayproductos = [];
        if ($productosvnt->count() > 0) {
            $ruta = env("RUTA_NUBEFACT");
            $token = env("TOKEN_NUBEFACT");
            $totaligv = 0;
            $totaltotal = 0;
            $totalgravado = 0;
            date_default_timezone_set('America/Lima');
            $fechaActual = date('d-m-Y');
            $detalleVenta = $productosvnt->detalleVentas;
            foreach ($detalleVenta as $row) {
                $valorIgv = ($row->product->precioVenta * 18 / 100);
                $precioUnitario = $row->product->precioVenta +  $valorIgv;
                $subtotalProd = round($row->product->precioVenta * $row->cantidad, 2);
                $subtotalIgv = round($subtotalProd * 18 / 100, 2);
                $prodformat = array(
                    "unidad_de_medida"          => "NIU",
                    "codigo"                    => strval($row->product->codigoProd),
                    "descripcion"               => strval($row->product->productsTipo->descripcion),
                    "cantidad"                  => strval($row->cantidad),
                    "valor_unitario"            => strval(round($row->product->precioVenta, 2)),
                    "precio_unitario"           => strval(round($precioUnitario, 2)),
                    "descuento"                 => "",
                    "subtotal"                  => strval($subtotalProd),
                    "tipo_de_igv"               => "1",
                    "igv"                       => strval($subtotalIgv),
                    "total"                     => strval($subtotalIgv + $subtotalProd),
                    "anticipo_regularizacion"   => "false",
                    "anticipo_documento_serie"  => "",
                    "anticipo_documento_numero" => ""
                );
                array_push($arrayproductos, $prodformat);

                $totaligv += $subtotalIgv;
                $totaltotal += $subtotalIgv + $subtotalProd;
                $totalgravado += $subtotalProd;
            }
            $tipocomprob = 0;
            $serie = "";
            $tipodocumento = "";
            $formato = "";
            $valorcompro = $productosvnt->tipo_compro;
            $doccliente = strlen($productosvnt->documento_cliente);


            if ($valorcompro == "FACTURA") {
                $tipocomprob = 1;
                $serie = "FFF1";
                $formato = "A4";
            } else {
                $tipocomprob = 2;
                $serie = "BBB1";
                $formato = "TICKET";
            }

            if ($doccliente == 11) {
                $tipodocumento = "6";
            } else {
                $tipodocumento = "1";
            }


            $data = array(
                "operacion"                => "generar_comprobante",
                "tipo_de_comprobante"               => strval($tipocomprob),
                "serie"                             => $serie,
                "numero"                =>  strval($productosvnt->id_venta),
                "sunat_transaction"            => "1",
                "cliente_tipo_de_documento"        => strval($tipodocumento),
                "cliente_numero_de_documento"    => strval($productosvnt->documento_cliente),
                "cliente_denominacion"              => strval($productosvnt->nombre_cliente),
                "cliente_direccion"                 => "",
                "cliente_email"                     => "",
                "cliente_email_1"                   => "",
                "cliente_email_2"                   => "",
                "fecha_de_emision"                  => $fechaActual,
                "fecha_de_vencimiento"              => "",
                "moneda"                            => "1",
                "tipo_de_cambio"                    => "",
                "porcentaje_de_igv"                 => "18.00",
                "descuento_global"                  => "",
                "descuento_global"                  => "",
                "total_descuento"                   => "",
                "total_anticipo"                    => "",
                "total_gravada"                     => strval($totalgravado),
                "total_inafecta"                    => "",
                "total_exonerada"                   => "",
                "total_igv"                         => strval($totaligv),
                "total_gratuita"                    => "",
                "total_otros_cargos"                => "",
                "total"                             => strval($totaltotal),
                "percepcion_tipo"                   => "",
                "percepcion_base_imponible"         => "",
                "total_percepcion"                  => "",
                "total_incluido_percepcion"         => "",
                "detraccion"                        => "false",
                "observaciones"                     => "",
                "documento_que_se_modifica_tipo"    => "",
                "documento_que_se_modifica_serie"   => "",
                "documento_que_se_modifica_numero"  => "",
                "tipo_de_nota_de_credito"           => "",
                "tipo_de_nota_de_debito"            => "",
                "enviar_automaticamente_a_la_sunat" => "true",
                "enviar_automaticamente_al_cliente" => "false",
                "codigo_unico"                      => "",
                "condiciones_de_pago"               => "",
                "medio_de_pago"                     => "",
                "placa_vehiculo"                    => "",
                "orden_compra_servicio"             => "",
                "tabla_personalizada_codigo"        => "",
                "formato_de_pdf"                    => $formato,
                "items" => $arrayproductos
            );
            $data_json = json_encode($data);

            //Invocamos el servicio de NUBEFACT
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $ruta);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Authorization: Token token="' . $token . '"',
                    'Content-Type: application/json',
                )
            );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $respuesta  = curl_exec($ch);
            curl_close($ch);

            //#### OBSERVAR ###
            $leer_respuesta = json_decode($respuesta, true);
            if (isset($leer_respuesta['errors'])) {
            } else {
                $this->repository->update($productosvnt->id_venta, ["enlaceComprobante" => $leer_respuesta['enlace']]);
            }
        } else {
            $leer_respuesta = array("errors" => "Sin elementos", "codigo" => "NEF");
        }
    }
}
