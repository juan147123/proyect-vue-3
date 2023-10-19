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
                <div class="col-12 my-2">
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
    </AppLayout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumbs from "@/Layouts/Breadcrumbs.vue";
import Spinner from "@/Layouts/Preloader.vue";

import { setSwal } from "../../../Utils/swal";

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
            formData: this.$inertia.form({
                id_aplicacion_usuario: 0,
                name: "",
                username: "",
                id_rol: "",
                objeto_permitido: "",
                id_usuario_rol: "",
            }),
        };
    },
    mounted() {
        /*   this.createTable(); */
    },
    methods: {
        createTable() {
            var self = this;
            this.table = new DataTable("#tableUsers", {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                },
                ajax: {
                    url: "/usuarios/" + localStorage.getItem("centro_gestion"),
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
                            self.deleteUser(data.id_aplicacion_usuario);
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
                    { data: "username" },
                    { data: "perfil" },
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
            this.formData = this.$inertia.form(user);
        },
        enabledSubmitAnimations(status, mensaje) {
            this.isLoading = status;
            this.mensaje = mensaje;
        },
        submit() {
            if (this.formData.id_aplicacion_usuario == 0) {
                this.create();
            } else {
                this.update();
            }
        },
        onSubmitEvent(typeSwal) {
            this.enabledSubmitAnimations(false, "");
            this.table.ajax.reload();
            $("#btn-close-modal-user").trigger("click");
            setSwal(typeSwal);
        },
        async create() {
            this.enabledSubmitAnimations(true, "registrando...");
            await axios
                .post(`/usuarios/aplicacion/create`, this.formData)
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
                .put(
                    `/usuarios/aplicacion/udpate/${this.formData.id_aplicacion_usuario}`,
                    this.formData
                )
                .then(async (response) => {
                    if (response.status == 200) {
                        this.onSubmitEvent(2);
                    } else {
                        console.log("error");
                    }
                });
        },
    },
};
</script>
