<template>
    <Spinner v-if="isLoading == true" :mensaje="mensaje"></Spinner>
    <div class="card card-contacts">
        <div class="card-header d-flex justify-content-sm-between">
            <p>Contactos</p>
            <div>
                <i
                    class="ph-bold button-header-contacts ph-plus-square text-info"
                    data-bs-toggle="modal"
                    data-bs-target="#modalContacts"
                ></i>
                <i
                    class="ph-bold button-header-contacts ph-x-square text-danger"
                    @click="showContacts"
                ></i>
            </div>
        </div>
        <div class="card-body overflow-auto">
            <div
                class="contact-content d-flex flex-column"
                v-for="(contact, index) in this.contacts"
            >
                <label for="">Contacto N° {{ index + 1 }}</label>
                <label class="label-contacts">Nombre: {{ contact.name }}</label>
                <label class="label-contacts"
                    >Documento:{{ contact.document_type }}</label
                >
                <label class="label-contacts"
                    >Número:{{ contact.document_number }}</label
                >
                <label class="label-contacts">Correo:{{ contact.email }}</label>
                <label class="label-contacts"
                    >Telefono:{{ contact.cellphone }}</label
                >
                <div class="text-end">
                    <i
                        class="ph-bold buttons-acction-contacts ph-pencil-simple-line m-1 text-info"
                        data-bs-toggle="modal"
                        data-bs-target="#modalContacts"
                        @click="showContact(contact)"
                    ></i>
                    <i
                        class="ph-bold buttons-acction-contacts ph-trash m-1 text-danger"
                        @click="this.delete(contact.id)"
                    ></i>
                </div>
            </div>
        </div>
    </div>
    <div
        class="modal fade"
        id="modalContacts"
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
                        {{ this.form.id == 0 ? "Registrar" : "Actualizar " }}
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
                            <label for="" class="form-label">Documento</label>
                            <select
                                class="form-select form-select-lg"
                                v-model="this.form.document_type"
                            >
                                <option selected>Seleccione</option>
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
                                >Nombres y apellidos</label
                            >
                            <input
                                required
                                type="text"
                                class="form-control"
                                v-model="this.form.name"
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
                            <label for="" class="form-label">Teléfono</label>
                            <input
                                required
                                type="text"
                                class="form-control"
                                v-model="this.form.cellphone"
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
</template>
<script>
import { setSwal } from "../../../../Utils/swal";
import * as mensajes from "../../../../Utils/message";
import Spinner from "@/Layouts/Preloader.vue";
export default {
    props: ["idcontact"],
    emits: ["showContacts", "reloadTable"],
    components: {
        Spinner,
    },
    data() {
        return {
            form: this.$inertia.form({
                id: 0,
                supplier_id: 0,
                name: "",
                document_type: "",
                document_number: "",
                email: "",
                cellphone: "",
            }),
            isLoading: false,
            mensaje: false,
            contacts: [],
        };
    },
    mounted() {
        this.getContacts();
    },
    methods: {
        enabledSubmitAnimations(status, mensaje) {
            this.isLoading = status;
            this.mensaje = mensaje;
        },
        submit() {
            this.form.supplier_id = this.idcontact;
            if (this.form.id == 0) {
                this.create();
            } else {
                this.update();
            }
        },
        async getContacts() {
            await axios
                .get(`proveedores/contact/list/all/` + this.idcontact)
                .then(async (response) => {
                    if (response.status == 200) {
                        this.contacts = response.data;
                    } else {
                        console.log("error");
                    }
                });
        },
        async create() {
            this.enabledSubmitAnimations(true, "registrando...");
            await axios
                .post(`proveedores/contact/create`, this.form)
                .then(async (response) => {
                    if (response.status == 200) {
                        this.getContacts();
                        this.onSubmitEvent(1);
                    } else {
                        console.log("error");
                    }
                });
        },
        async update() {
            this.enabledSubmitAnimations(true, "actualizando...");
            await axios
                .put(`proveedores/contact/update/` + this.form.id, this.form)
                .then(async (response) => {
                    if (response.status == 200) {
                        this.getContacts();
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
                        .put(`proveedores/contact/delete/${id}`)
                        .then(async (response) => {
                            if (response.status == 200) {
                                this.getContacts();
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
        showContacts() {
            this.$emit("showContacts");
        },
        reloadTable() {
            this.$emit("reloadTable");
        },
        showContact(data) {
            this.form = this.$inertia.form(data);
        },
    },
};
</script>
<style scoped>
.card-contacts {
    margin-left: 10px;
    width: 500px;
    border: none;
    background-color: transparent;
    transition: all 0.3s;
}
.card-contacts .card-header {
    padding-left: 12px !important;
    padding-right: 12px !important;
    padding-bottom: 0px !important;
    background-color: rgb(255, 255, 255);
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px,
        rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
    transition: all 0.3s;
}
.card-body label {
    font-size: 14px;
}
.button-header-contacts {
    font-size: 25px !important;
    cursor: pointer;
}
.contact-content {
    box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;
    background-color: white !important;
    padding: 10px;
    width: 100%;
}
.label-contacts {
    margin-left: 15px;
}
.buttons-acction-contacts {
    font-size: 16px;
    cursor: pointer;
}
</style>
