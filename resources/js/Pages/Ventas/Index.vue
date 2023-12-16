<template>
    <Spinner v-if="isLoading == true" :mensaje="mensaje"></Spinner>
    <AppLayout>
        <Breadcrumbs :modules="modulos" />
        <div class="main-content">
            <div class="mx-3 my-3">
                <div class="text-end my-3">
                    <button
                        type="button"
                        class="btn btn-primary btn-sm my-3"
                        data-bs-toggle="modal"
                        data-bs-target="#modalVenta"
                        @click="disabledIsedit"
                    >
                        <i class="ph ph-file-plus"></i>
                        Nuevo
                    </button>
                </div>
                <div class="box">
                    <div class="container-fluid">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table
                                    id="tableVenta"
                                    class="table table-bordered dt-responsive"
                                >
                                    <thead class="active">
                                        <tr>
                                            <th>Código</th>
                                            <th>Documento cliente</th>
                                            <th>Número</th>
                                            <th>Nombre cliente</th>
                                            <th>Responsable</th>
                                            <th>Registrado</th>
                                            <th>Tipo de comprobante</th>
                                            <th>Total de venta</th>
                                            <th>Detalle</th>
                                            <th>Comprobante</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="modalVenta"
            tabindex="-1"
            role="dialog"
            aria-labelledby="tituloUsuarios"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Venta</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            id="btn-close-modal-venta"
                            @click="clearform"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 mx-3">
                                        <label for="" class="form-label"
                                            >Documento:</label
                                        >
                                        <select
                                            class="form-select form-select-sm"
                                            id="tipo_documento_cliente"
                                            required
                                        >
                                            <option value="" selected>
                                                Seleccione
                                            </option>
                                            <option value="DNI">DNI</option>
                                            <option value="RUC">RUC</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 mx-3">
                                        <label for="" class="form-label"
                                            >Nombres y Apellidos del
                                            cliente:</label
                                        >
                                        <input
                                            type="text"
                                            id="nombre_cliente"
                                            class="form-control"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 mx-3">
                                        <label for="" class="form-label"
                                            >Número de documento:</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="documento_cliente"
                                            required
                                        />
                                    </div>
                                    <div class="mb-3 mx-3">
                                        <label for="" class="form-label"
                                            >Tipo de comprobante:</label
                                        >
                                        <select
                                            class="form-select form-select-sm"
                                            id="tipo_compro"
                                            required
                                        >
                                            <option value="" selected>
                                                Seleccione
                                            </option>
                                            <option value="BOLETA">
                                                BOLETA
                                            </option>
                                            <option value="FACTURA">
                                                FACTURA
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            Productos
                            <div class="d-flex" v-if="isEdit == false">
                                <div class="p-1">
                                    <label for="">Seleccione un producto</label>
                                    <select
                                        class="form-select form-select-lg"
                                        @change="setMax"
                                        id="selectProdDet"
                                    >
                                        <option value="">
                                            Seleccione producto
                                        </option>
                                        <option
                                            v-for="product in productos"
                                            :value="product.id_prod"
                                            :data-key="product.stock"
                                            :data-price="product.precioVenta"
                                        >
                                            {{ product.codigoProd }} -
                                            {{
                                                product.products_tipo
                                                    .descripcion
                                            }}
                                        </option>
                                    </select>
                                </div>
                                <div class="p-1">
                                    <label for="">Stock disponible</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        :value="max"
                                        readonly
                                    />
                                </div>
                                <div class="p-1">
                                    <label for="">Precio de venta</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="precioVenta"
                                        :value="precio_venta"
                                        readonly
                                    />
                                </div>
                                <div class="p-1">
                                    <label for=""
                                        >Ingrese cantidad a vender</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="cantidadVenta"
                                        min="1"
                                        :max="max"
                                        aria-describedby="helpId"
                                        placeholder=""
                                        @input="checkMax"
                                    />
                                </div>
                                <div class="p-1 d-flex align-items-center">
                                    <a
                                        class="btn btn-primary btn-sm mt-3"
                                        role="button"
                                        @click="addProductDetail"
                                    >
                                        <i class="ph-bold ph-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <small
                                id="helpId"
                                class="form-text text-danger p-2"
                                v-if="exceedsMax"
                            >
                                La cantidad no debe exceder el máximo de stock
                                permitido para el producto.
                            </small>
                            <hr />
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-primary">
                                        <thead>
                                            <tr>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Monto</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="text-center"
                                                v-for="(
                                                    prodDetail, index
                                                ) in productosDetalle"
                                            >
                                                <td>
                                                    {{ prodDetail.descripcion }}
                                                </td>
                                                <td>
                                                    {{ prodDetail.cantidad }}
                                                </td>
                                                <td>{{ prodDetail.precio }}</td>
                                                <td>
                                                    {{
                                                        (
                                                            prodDetail.precio *
                                                            prodDetail.cantidad
                                                        ).toFixed(2)
                                                    }}
                                                </td>
                                                <td>
                                                    <i
                                                        @click="
                                                            eliminarProductoDetalle(
                                                                index
                                                            )
                                                        "
                                                        class="ph-bold ph-x-circle text-danger"
                                                    ></i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex flex-row-reverse">
                                    <div class="">
                                        <div class=" ">
                                            <label class="m-1">IGV%</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                readonly
                                                value="18"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row-reverse">
                                    <div class="mb-2">
                                        <div class="">
                                            <label class="m-1"
                                                >Total a pagar</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                :value="total_venta"
                                                readonly
                                                value="18"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    data-bs-dismiss="modal"
                                    @click="clearform"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="Submit"
                                    class="btn btn-primary"
                                    v-if="isEdit == false"
                                >
                                    Vender
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumbs from "@/Layouts/Breadcrumbs.vue";
import Spinner from "@/Layouts/Preloader.vue";

import { setSwal } from "../../../Utils/swal";
import * as mensajes from "../../../Utils/message";

export default {
    components: {
        AppLayout,
        Breadcrumbs,
        Spinner,
    },
    data() {
        return {
            modulos: [
                {
                    label: "Ventas",
                    icon: "ph-scales",
                    url: "ventas",
                },
            ],
            isLoading: false,
            mensaje: false,
            table: "",
            isEdit: false,
            max: 0,
            exceedsMax: false,
            productos: [],
            productosDetalle: [],
            precio_venta: 0,
            total_venta: 0,
        };
    },
    mounted() {
        this.createTable();
        this.listProducts();
    },
    methods: {
        setData(data) {
            this.productosDetalle = [];
            var documentoCliente = $("#tipo_documento_cliente");
            var numeroDocumentoCliente = $("#documento_cliente");
            var nombreCliente = $("#nombre_cliente");
            var tipoCompro = $("#tipo_compro");

            documentoCliente.val(data.tipo_documento_cliente);
            nombreCliente.val(data.nombre_cliente);
            numeroDocumentoCliente.val(data.documento_cliente);
            tipoCompro.val(data.tipo_compro);

            documentoCliente.prop("disabled", true);
            numeroDocumentoCliente.prop("disabled", true);
            nombreCliente.prop("disabled", true);
            tipoCompro.prop("disabled", true);

            var detalleVenta = data.detalle_ventas;
            detalleVenta.forEach((detalle) => {
                console.log(detalle);

                var nuevoProdDetalle = {
                    id_prod: detalle.id_prod,
                    descripcion:
                        detalle.product.codigoProd +
                        "-" +
                        detalle.product.products_tipo.descripcion,
                    cantidad: detalle.cantidad,
                    precio: detalle.product.precioVenta,
                };
                this.productosDetalle.push(nuevoProdDetalle);
                this.calcularSuma();
            });
        },
        disabledIsedit() {
            this.isEdit = false;
            var documentoCliente = $("#tipo_documento_cliente");
            var numeroDocumentoCliente = $("#documento_cliente");
            var nombreCliente = $("#nombre_cliente");
            var tipoCompro = $("#tipo_compro");
            documentoCliente.prop("disabled", false);
            numeroDocumentoCliente.prop("disabled", false);
            nombreCliente.prop("disabled", false);
            tipoCompro.prop("disabled", false);
            documentoCliente.val("");
            numeroDocumentoCliente.val("");
            nombreCliente.val("");
            tipoCompro.val("");
            this.productosDetalle = [];
            this.calcularSuma();
        },
        submit() {
            var data = {
                tipo_documento_cliente: $("#tipo_documento_cliente").val(),
                documento_cliente: $("#documento_cliente").val(),
                nombre_cliente: $("#nombre_cliente").val(),
                tipo_compro: $("#tipo_compro").val(),
                total_venta: this.total_venta,
                detalle_venta: this.productosDetalle,
            };
            var form = this.$inertia.form(data);
            this.create(form);
        },
        enabledSubmitAnimations(status, mensaje) {
            this.isLoading = status;
            this.mensaje = mensaje;
        },
        onSubmitEvent(typeSwal) {
            //this.clearform();
            this.enabledSubmitAnimations(false, "");
            this.table.ajax.reload();
            $("#btn-close-modal-venta").trigger("click");
            setSwal(typeSwal);
        },
        async create(form) {
            this.enabledSubmitAnimations(true, "registrando...");
            await axios.post(`ventas/create`, form).then(async (response) => {
                if (response.status == 200) {
                    this.onSubmitEvent(1);
                } else {
                    console.log("error");
                }
            });
        },

        eliminarProductoDetalle(index) {
            this.productosDetalle.splice(index, 1);
        },
        addProductDetail() {
            var selectedOption = $("#selectProdDet").find(":selected");
            var cantidadVenta = $("#cantidadVenta").val();
            var precioVenta = $("#precioVenta").val();
            var value = selectedOption.val();
            var descripcion = selectedOption.text();
            var existingProduct = this.productosDetalle.find(
                (prod) => prod.id_prod === value
            );

            if (!existingProduct && value != "" && cantidadVenta != 0) {
                var nuevoProdDetalle = {
                    id_prod: value,
                    descripcion: descripcion,
                    cantidad: cantidadVenta,
                    precio: precioVenta,
                };

                this.productosDetalle.push(nuevoProdDetalle);
            }
            this.calcularSuma();
        },
        calcularSuma() {
            var suma = this.productosDetalle.reduce((total, prod) => {
                return (
                    total + parseFloat(prod.cantidad) * parseFloat(prod.precio)
                );
            }, 0);
            this.total_venta = (suma * 1.18).toFixed(2);
        },
        checkMax(event) {
            const inputValue = parseInt(event.target.value, 10);
            const max = parseInt(this.max, 10);
            if (inputValue > max) {
                this.exceedsMax = true;
            } else {
                this.exceedsMax = false;
            }
        },
        setMax() {
            var max = $("#selectProdDet").find(":selected").attr("data-key");
            var price = $("#selectProdDet")
                .find(":selected")
                .attr("data-price");
            this.max = max;
            this.precio_venta = price;
        },
        async listProducts() {
            await axios
                .get(`productos/all`, this.form)
                .then(async (response) => {
                    if (response.status == 200) {
                        this.productos = response.data;
                    } else {
                        console.log("error");
                    }
                });
        },
        createTable() {
            var self = this;
            this.table = new DataTable("#tableVenta", {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                },
                ajax: {
                    url: "/ventas/all",
                    dataSrc: "",
                },
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 },
                ],
                drawCallback: function (settings) {
                    $("ul.pagination").addClass("pagination-sm");
                },
                createdRow: function (row, data, dataIndex) {
                    $(row)
                        .find(".edit-btn")
                        .on("click", function () {
                            self.isEdit = true;
                            self.setData(data);
                        });
                },
                ordering: false,
                loadingRecords: "Cargando...",
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
                },
                autoFill: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 },
                ],
                columns: [
                    { data: "codigo", className: "text-center" },
                    {
                        data: "tipo_documento_cliente",
                        className: "text-center",
                    },
                    { data: "documento_cliente", className: "text-center" },
                    { data: "nombre_cliente", className: "text-center" },
                    { data: "responsable", className: "text-center" },
                    { data: "fecha_registro", className: "text-center" },
                    { data: "tipo_compro", className: "text-center" },
                    { data: "total_venta", className: "text-center" },
                    {
                        data: null,
                        width: "100px",
                        addClass: "text-center",
                        render: function (data, type, row) {
                            return (
                                '<div class="text-center">' +
                                '<button class="btn btn-info btn-sm edit-btn mx-1"  data-bs-toggle="modal" data-bs-target="#modalVenta">' +
                                '<i class="ph ph-bold ph-clipboard-text"></i>' +
                                "</button>" +
                                "</div>"
                            );
                        },
                    },
                    {
                        data: "enlaceComprobante",
                        width: "100px",
                        addClass: "text-center",
                        render: function (data, type, row) {
                            return (
                                '<div class="text-center">' +
                                '<a class="btn btn-primary btn-sm  mx-1" target="_blank" href ="' +
                                data +
                                '">' +
                                '<i class="ph ph-bold ph-file m-1"></i>' +
                                row.tipo_compro +
                                "</a>" +
                                "</div>"
                            );
                        },
                    },
                ],
            });
        },
    },
};
</script>
