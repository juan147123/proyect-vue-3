<template>
    <Spinner v-if="isLoading == true" :mensaje="mensaje"></Spinner>
    <AppLayout>
        <Breadcrumbs :modules="modulos" />
        <div class="main-content">
            <div class="mx-3 my-3">
                <div class="text-end my-3">
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalUsers"
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
                                    id="tableUsers"
                                    class="table table-bordered dt-responsive"
                                >
                                    <thead class="active">
                                        <tr>
                                            <th>Nombres y apellidos</th>

                                            <th>Correo electrónico</th>
                                            <th>Perfil</th>

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
        <!-- Modal -->
        <div
            class="modal fade"
            id="modalUsers"
            tabindex="-1"
            role="dialog"
            aria-labelledby="tituloUsuarios"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloUsuarios">
                            {{ form.id == 0 ? "Registrar" : "Editar" }}
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
                                    {{ form.id == 0 ? "Registrar" : "Editar" }}
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
                    label: "Usuarios",
                    icon: "ph-users",
                    url: "users",
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
            this.table = new DataTable("#tableUsers", {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                },
                ajax: {
                    url: "/usuarios/list/",
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
                    { data: "name" },
                    {
                        data: "email",
                    },
                    {
                        data: "id_rol",
                        render: function (data, type, row) {
                            var rol = "";
                            if (data == 1) {
                                rol = "Administrador";
                            }
                            return `<span>${rol}</span>`;
                        },
                    },
                    {
                        data: null,
                        width: "100px",
                        addClass: "text-center",
                        render: function (data, type, row) {
                            return (
                                '<button class="btn btn-primary btn-sm edit-btn mx-1"  data-bs-toggle="modal" data-bs-target="#modalUsers">' +
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
        showUser(user) {
            this.form = this.$inertia.form(user);
        },
        enabledSubmitAnimations(status, mensaje) {
            this.isLoading = status;
            this.mensaje = mensaje;
        },
        submit() {
            if (this.form.id == 0) {
                this.create();
            } else {
                this.update();
            }
        },

        async create() {
            this.enabledSubmitAnimations(true, "registrando...");
            await axios
                .post(`usuarios/create`, this.form)
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
                .put(`usuarios/update`, this.form)
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
                        .put(`usuarios/delete/${id}`)
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
            this.clearform();
            this.enabledSubmitAnimations(false, "");
            this.table.ajax.reload();
            $("#btn-close-modal-user").trigger("click");
            setSwal(typeSwal);
        },
        clearform() {
            this.form.id = 0;
            this.form.name = "";
            this.form.email = "";
            this.form.id_rol = "";
            this.form.password = "";
        },
    },
};
</script>
