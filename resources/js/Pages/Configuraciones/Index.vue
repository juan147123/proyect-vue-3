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
    </AppLayout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumbs from "@/Layouts/Breadcrumbs.vue";
import Spinner from "@/Layouts/Preloader.vue";

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
    methods: {
        submit() {
            if (this.form.id == 0) {
                this.create();
            } else {
                this.update();
            }
        },
        createTable() {
            var self = this;
            this.table = new DataTable("#tableProveedores", {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                },
                ajax: {
                    url: "/proveedores/list",
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
                        .find(".contacts-btn")
                        .on("click", function () {
                            self.SetContacts(data);
                        });
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
                        data: "document_type",
                        width: 100,
                    },
                    {
                        data: "document_number",
                    },
                    { data: "business_name" },
                    {
                        data: "email",
                    },
                    {
                        data: "address",
                    },
                    {
                        data: null,
                        width: "100px",
                        className: "text-center",
                        render: function (data, type, row) {
                            return (
                                '<button class="btn btn-primary btn-sm contacts-btn mx-1">' +
                                '<i class="ph ph-bold ph-user"></i>' +
                                "</button>"
                            );
                        },
                    },
                    {
                        data: null,
                        width: "100px",
                        className: "text-center",
                        render: function (data, type, row) {
                            return (
                                '<button class="btn btn-primary btn-sm edit-btn mx-1"  data-bs-toggle="modal" data-bs-target="#modalSuppliers">' +
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
            this.enabledSubmitAnimations(true, "registrando...");
            await axios
                .post(`proveedores/create`, this.form)
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
                .put(`proveedores/update/` + this.form.id, this.form)
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
                        .put(`proveedores/delete/${id}`)
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
            this.form.supplier_id = 0;
            this.form.name = "";
            this.form.document_type = "";
            this.form.document_number = "";
            this.form.email = "";
            this.form.cellphone = "";
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
