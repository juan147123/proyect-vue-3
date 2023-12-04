<template>
    <Spinner v-if="isLoading == true" :mensaje="mensaje"></Spinner>
    <AppLayout>
        <div class="bread">
            <Breadcrumbs :modules="modulos" />
        </div>
        <div class="d-flex">
            <div class="main-contact">
                <div class="mx-3 my-3">
                    <div class="text-end my-3">
                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalSuppliers"
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
                                        id="tableProveedores"
                                        class="table text-nowrap table-bordered dt-responsive"
                                    >
                                        <thead class="active">
                                            <tr>
                                                <th>Documento</th>
                                                <th>Número</th>
                                                <th>Nombre / Razon social</th>
                                                <th>Dirección</th>
                                                <th>Correo</th>
                                                <th>Contactos</th>
                                                <th>acciones</th>
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
            <Contacts
                :idcontact="idcontact"
                v-if="contactsView == true"
                @showContacts="showContacts"
                @reloadTable="reloadTable"
            />
        </div>

        <div
            class="modal fade"
            id="modalSuppliers"
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
                            contacto
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
                                    >Documento</label
                                >
                                <select
                                    class="form-select form-select-lg"
                                    v-model="this.form.document_type"
                                >
                                    <option selected value="">
                                        Seleccione
                                    </option>
                                    <option value="1">DNI</option>
                                    <option value="2">RUC</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Número</label>
                                <input
                                    required
                                    type="text"
                                    class="form-control"
                                    v-model="this.form.document_number"
                                    aria-describedby="helpId"
                                    placeholder=""
                                />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label"
                                    >Razon social / Nombre
                                </label>
                                <input
                                    required
                                    type="text"
                                    class="form-control"
                                    v-model="this.form.business_name"
                                    aria-describedby="helpId"
                                    placeholder=""
                                />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label"
                                    >Correo electrónico</label
                                >
                                <input
                                    required
                                    type="email"
                                    class="form-control"
                                    v-model="this.form.email"
                                    aria-describedby="helpId"
                                    placeholder=""
                                />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label"
                                    >Dirección</label
                                >
                                <textarea
                                    required
                                    type="text"
                                    class="form-control"
                                    v-model="this.form.address"
                                    aria-describedby="helpId"
                                    placeholder=""
                                ></textarea>
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
import Contacts from "./Contacts/Index.vue";

export default {
    components: {
        AppLayout,
        Breadcrumbs,
        Spinner,
        Contacts,
    },
    data() {
        return {
            modulos: [
                {
                    label: "Proveedores",
                    icon: "ph-users",
                    url: "proveedores",
                },
            ],
            isLoading: false,
            mensaje: false,
            table: [],
            form: this.$inertia.form({
                id: 0,
                business_name: "",
                document_type: "",
                document_number: "",
                address: "",
                email: "",
            }),
            idcontact: 0,
            contactsView: false,
        };
    },
    mounted() {
        this.createTable();
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

        SetContacts(data) {
            this.showContacts();
            this.idcontact = data.id;
        },
        showContacts() {
            this.contactsView = !this.contactsView;
        },
    },
};
</script>
<style scoped>
.contenedor-contactos {
    margin-top: 12px;
    transition: all 0.3s;
}
.bread {
    margin-top: 50px;
}
</style>
