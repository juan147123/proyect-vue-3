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
                        <h5 class="modal-title" id="tituloUsuarios">
                         Venta
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            id="btn-close-modal-user"
                            @click="clearform"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submit">
                            <div class="mb-3 mx-3">
                                <label for="" class="form-label">Perfil:</label>
                                <select
                                    class="form-select form-select-lg"
                                    v-model="form.id_rol"
                                    required
                                >
                                    <option value="" selected>
                                        Seleccione
                                    </option>
                                    <option value="1">Administrador</option>
                                </select>
                            </div>
                            <div class="mb-3 mx-3">
                                <label for="" class="form-label"
                                    >Nombres y Apellidos:</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.name"
                                    placeholder="Ingrese su nombre y apellidos"
                                    required
                                />
                            </div>
                            <div class="mb-3 mx-3">
                                <label for="" class="form-label"
                                    >Correo electrrónico:</label
                                >
                                <input
                                    type="email"
                                    class="form-control"
                                    v-model="form.email"
                                    placeholder="Ingrese su correo electrónico"
                                    required
                                />
                            </div>
                            <div class="mb-3 mx-3">
                                <label for="" class="form-label"
                                    >Contraseña:</label
                                >
                                <input
                                    type="password"
                                    class="form-control"
                                    v-model="form.password"
                                    :required="form.id == 0"
                                />
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
                                <button type="Submit" class="btn btn-primary">
                                   Registrar
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
            form: this.$inertia.form({
                id: 0,
                name: "",
                email: "",
                id_rol: "",
                password: "",
            }),
        };
    },
    mounted() {
        this.createTable();
    },
    methods: {
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
                            self.showUser(data);
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
                    { data: "codigo",  className: "text-center", },
                    {
                        data: "tipo_documento_cliente",
                        className: "text-center",
                    },
                    { data: "documento_cliente",  className: "text-center", },
                    { data: "nombre_cliente",  className: "text-center", },
                    { data: "responsable",  className: "text-center", },
                    { data: "fecha_registro" ,  className: "text-center",},
                    { data: "tipo_compro" ,  className: "text-center",},
                    { data: "total_venta" ,  className: "text-center",},
                    {
                        data: null,
                        width: "100px",
                        addClass: "text-center",
                        render: function (data, type, row) {
                            return (
                                '<div class="text-center">'+
                                '<button class="btn btn-primary btn-sm edit-btn mx-1"  data-bs-toggle="modal" data-bs-target="#modalUsers">' +
                                '<i class="ph ph-bold ph-file"></i>' +
                                "</button>"+
                                '</div>' 
                            );
                        },
                    },
                ],
            });
        },
    },
};
</script>
