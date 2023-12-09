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
                        data-bs-target="#modalConfiguracion"
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
                                            <th>Descripción</th>
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
            id="modalConfiguracion"
            tabindex="-1"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            role="dialog"
            aria-labelledby="modalTitleId"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="modalTitleId">
                            {{
                                this.form.id == 0 ? "Registrar" : "Actualizar "
                            }}
                            {{ this.modulo }}
                        </p>
                        <button
                            type="button"
                            class="btn-close btn-sm"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            id="btn-close-modal-contacts"
                            @click="clearForm"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label for="" class="form-label"
                                    >Descripción
                                </label>
                                <input
                                    required
                                    type="text"
                                    class="form-control"
                                    v-model="this.form.descripcion"
                                    aria-describedby="helpId"
                                    placeholder=""
                                />
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
                                        this.form.id == 0
                                            ? "Registrar"
                                            : "Actualizar "
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
                    label: "",
                    icon: "ph-users",
                    url: "",
                },
            ],
            isLoading: false,
            mensaje: false,
            table: "",
            modulo: "",
            form: this.$inertia.form({
                id: 0,
                descripcion: "",
                uso: "",
            }),
        };
    },
    mounted() {
        this.asingModule();
        this.createTable();
    },
    methods: {
        asingModule() {
            var rutaActual = window.location.href;
            var segmentos = rutaActual.split("/");
            var modulo = segmentos[4];
            this.modulos[0].label = modulo;
            this.modulos[0].url = modulo;
            this.modulo = modulo;
        },
        submit() {
            if (this.form.id == 0) {
                this.create();
            } else {
                this.update();
            }
        },
        createTable() {
            var self = this;
            this.table = new DataTable("#tableConfiguracion", {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                },
                ajax: {
                    url: "/configuraciones/all/" + this.modulo,
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
                    {
                        data: "descripcion",
                        width: 100,
                        className: "text-center",
                    },
                    {
                        data: null,
                        width: "100px",
                        className: "text-center",
                        render: function (data, type, row) {
                            return (
                                '<button class="btn btn-primary btn-sm edit-btn mx-1"  data-bs-toggle="modal" data-bs-target="#modalConfiguracion">' +
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
        reloadTable() {
            this.table.ajax.reload();
        },
        async create() {
            this.form.uso = this.modulo;
            this.enabledSubmitAnimations(true, "registrando...");
            await axios
                .post(`create`, this.form)
                .then(async (response) => {
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
                .put(`update/` + this.form.id, this.form)
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
                    axios
                        .put(`delete/${id}`)
                        .then(async (response) => {
                            if (response.status == 200) {
                                this.onSubmitEvent(3);
                            } else {
                                console.log("error");
                            }
                        });
                }
            });
        },
        onSubmitEvent(typeSwal) {
            this.clearForm();
            this.reloadTable();
            this.enabledSubmitAnimations(false, "");
            $("#btn-close-modal-contacts").trigger("click");
            setSwal(typeSwal);
        },
        clearForm() {
            this.form.id = 0;
            this.form.uso = "";
            this.form.descripcion = "";
        },
        enabledSubmitAnimations(status, mensaje) {
            this.isLoading = status;
            this.mensaje = mensaje;
        },
        show(data) {
            this.form = this.$inertia.form(data);
        },
    },
};
</script>
