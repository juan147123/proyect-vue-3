<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_venta
 * @property string $codigo
 * @property string $tipo_documento_cliente
 * @property string $documento_cliente
 * @property string $nombre_cliente
 * @property string $responsable
 * @property string $fecha_registro
 * @property string $tipo_compro
 * @property integer $enable
 * @property string $created_at
 * @property string $updated_at
 * @property DetalleVenta[] $detalleVentas
 */
class Venta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'venta';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_venta';

    /**
     * @var array
     */
    protected $fillable = ['codigo', 'tipo_documento_cliente', 'documento_cliente', 'nombre_cliente', 'responsable', 'fecha_registro', 'tipo_compro', 'enable', 'created_at', 'updated_at','total_venta','enlaceComprobante'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleVentas()
    {
        return $this->hasMany('App\Models\DetalleVenta', 'id_venta', 'id_venta');
    }
}
