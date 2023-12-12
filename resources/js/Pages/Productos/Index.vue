<template>
    <Spinner v-if="isLoading == true" :mensaje="mensaje"></Spinner>
    <AppLayout>
        <div class="bread">
            <Breadcrumbs :modules="modulos" />
        </div>
        <div class="main-content">
            <div class="mx-3 my-3">
                <div class="text-end my-3">
                    <button
                        type="button"
                        class="btn btn-primary btn-sm my-3"
                        data-bs-toggle="modal"
                        data-bs-target="#modalProducts"
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
                                    id="tableConfiguracion"
                                    class="table table-bordered dt-responsive"
                                >
                                    <thead class="active">
                                        <tr>
                                            <th>Código</th>
                                            <th>Proveedor</th>
                                            <th>Descripción</th>
                                            <th>Unidad de medida</th>
                                            <th>Precio de compra</th>
                                            <th>Porcentaje de ganancia</th>
                                            <th>Precio de venta</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
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
            id="modalProducts"
            tabindex="-1"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            role="dialog"
            aria-labelledby="modalTitleId"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            {{ form.id_prod == 0 ? "Registrar" : "Actualizar" }}
                            Producto
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            id="btn-close-products"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            @click="clearForm"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="" class="form-label"
                                            >Seleccione Proveedor</label
                                        >
                                        <select
                                            class="form-select form-select-sm"
                                            v-model="form.id_supp"
                                            required
                                        >
                                            <option selected value="">
                                                Seleccione
                                            </option>
                                            <option
                                                v-for="proveedor in proveedores"
                                                :value="proveedor.id"
                                            >
                                                {{ proveedor.business_name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label"
                                            >Seleccione Producto</label
                                        >
                                        <select
                                            class="form-select form-select-sm"
                                            v-model="form.idTipoProducto"
                                            required
                                        >
                                            <option selected value="">
                                                Seleccione
                                            </option>
                                            <option
                                                v-for="producto in productos"
                                                :value="producto.id"
                                            >
                                                {{ producto.descripcion }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label"
                                            >Seleccione la unidad de
                                            medida</label
                                        >
                                        <select
                                            class="form-select form-select-sm"
                                            v-model="form.idTipoUnidadMedida"
                                            required
                                        >
                                            <option selected value="">
                                                Seleccione
                                            </option>
                                            <option
                                                v-for="unidad in unidades"
                                                :value="unidad.id"
                                            >
                                                {{ unidad.descripcion }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label"
                                            >Ingrese el precio de compra</label
                                        >
                                        <input
                                            type="number"
                                            min="0"
                                            required
                                            v-model="form.precioCompra"
                                            class="form-control"
                                            @change="setValueVenta"
                                        />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="" class="form-label"
                                            >Ingrese el porcentaje de
                                            ganancia</label
                                        >
                                        <input
                                            type="number"
                                            min="0"
                                            required
                                            @change="setValueVenta"
                                            class="form-control"
                                            v-model="form.porcentaje"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label"
                                            >Precio de venta</label
                                        >
                                        <input
                                            type="number"
                                            min="0"
                                            required
                                            v-model="form.precioVenta"
                                            readonly
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label"
                                            >Stock</label
                                        >
                                        <input
                                            type="number"
                                            min="0"
                                            required
                                            v-model="form.stock"
                                            class="form-control"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm"
                                    data-bs-dismiss="modal"
                                    @click="clearForm"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-sm"
                                >
                                    {{
                                        form.id_prod == 0
                                            ? "Registrar"
                                            : "Actualizar"
                                    }}
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
                    label: "Productos",
                    icon: "ph-users",
                    url: "productos",
                },
            ],
            isLoading: false,
            mensaje: false,
            table: [],
            proveedores: [],
            productos: [],
            unidades: [],
            form: this.$inertia.form({
                id_prod: 0,
                id_supp: "",
                idTipoProducto: "",
                idTipoUnidadMedida: "",
                precioCompra: 0,
                porcentaje: 0,
                precioVenta: 0,
                stock: 0,
            }),
        };
    },
    mounted() {
        this.createTable();
        this.loadSelects();
    },
    methods: {
        loadSelects() {
            this.productos = this.$page.props.data.productos;
            this.proveedores = this.$page.props.data.proveedores;
            this.unidades = this.$page.props.data.unidades;
        },
        createTable() {
            var self = this;
            this.table = new DataTable("#tableConfiguracion", {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                },
                ajax: {
                    url: "/productos/all",
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
                            self.show(data);
                        });
                    $(row)
                        .find(".delete-btn")
                        .on("click", function () {
                            self.delete(data.id);
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
                    { data: "codigoProd", className: "text-center" },
                    {
                        data: "supplier.business_name",
                        className: "text-center",
                    },
                    {
                        data: "products_tipo.descripcion",
                        className: "text-center",
                    },
                    {
                        data: "products_u_m.descripcion",
                        className: "text-center",
                    },
                    { data: "precioCompra", className: "text-center" },
                    { data: "porcentaje", className: "text-center" },
                    { data: "precioVenta", className: "text-center" },
                    { data: "stock", className: "text-center" },
                    { data: "estado", className: "text-center" },
                    {
                        data: null,
                        width: "100px",
                        className: "text-center",
                        render: function (data, type, row) {
                            return (
                                '<button class="btn btn-primary btn-sm edit-btn mx-1"  data-bs-toggle="modal" data-bs-target="#modalProducts">' +
                                '<i class="ph ph-bold ph-pen"></i>' +
                                "</button>" +
                                '<button class="btn btn-danger btn-sm delete-btn text-white mx-1">' +
                                '<i class="ph ph-bold ph-trash"></i>' +
                                "</button>"
                            );
                        },
                    },
                ],
            });
        },
        submit() {
            if (this.form.id_prod == 0) {
                this.create();
            } else {
                this.update();
            }
        },
        async create() {
            this.enabledSubmitAnimations(true, "registrando...");
            await axios.post(`productos/create`, this.form).then(async (response) => {
                if (response.status == 200) {
                    this.onSubmitEvent(1);
                } else {
                    console.log("error");
                }
            });
        },
        async update() {
            this.enabledSubmitAnimations(true, "actualizando...");
            await axios
                .put(`productos/update/` + this.form.id_prod, this.form)
                .then(async (response) => {
                    if (response.status == 200) {
                        this.onSubmitEvent(2);
                    } else {
                        console.log("error");
                    }
                });
        },
        delete(id) {
            self = this;
            Swal.fire({
                title: mensajes.MENSAJE_SEGURO,
                text: mensajes.MENSAJE_ELIMINAR,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.enabledSubmitAnimations(true, "eliminado...");
                    axios.put(`productos/delete/${id}`).then(async (response) => {
                        if (response.status == 200) {
                            this.onSubmitEvent(3);
                        } else {
                            console.log("error");
                        }
                    });
                }
            });
        },
        reloadTable() {
            this.table.ajax.reload();
        },
        onSubmitEvent(typeSwal) {
            this.clearForm();
            this.reloadTable();
            this.enabledSubmitAnimations(false, "");
            $("#btn-close-products").trigger("click");
            setSwal(typeSwal);
        },
        clearForm() {
            this.form.id_prod = 0;
            this.form.id_supp = "";
            this.form.idTipoProducto = "";
            this.form.idTipoUnidadMedida = "";
            this.form.precioCompra = 0;
            this.form.porcentaje = 0;
            this.form.precioVenta = 0;
            this.form.stock = 0;
        },
        enabledSubmitAnimations(status, mensaje) {
            this.isLoading = status;
            this.mensaje = mensaje;
        },
        show(data) {
            this.form = this.$inertia.form(data);
        },
        setValueVenta() {
            var porcentaje =
                this.form.precioCompra * (this.form.porcentaje / 100);
            this.form.precioVenta = this.form.precioCompra + porcentaje;
        },
    },
};
</script>
