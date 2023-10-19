<template>
    <div class="container-login-app">
        <div class="background">
            <svg viewBox="10 0 80 20" style="position: absolute; bottom: 0">
                <path
                    fill="#5f92d1"
                    opacity="0.1"
                    d="M0 30 V12 Q30 20 55 12 T100 11 V30z"
                    style="position: absolute"
                ></path>
            </svg>
            <svg viewBox="10 10 80 20" style="position: absolute; bottom: 0">
                <path
                    fill="#5f92d1"
                    opacity="0.1"
                    d="M0 30 V12 Q30 20 55 12 T100 11 V30z"
                    style="position: absolute"
                ></path>
            </svg>
            <svg viewBox="10 30 60 20" style="position: absolute; bottom: 0">
                <path
                    fill="#5f92d1"
                    opacity="0.1"
                    d="M0 30 V12 Q30 20 55 12 T100 11 V30z"
                    style="position: absolute"
                ></path>
            </svg>
        </div>
        <div class="forehead">
            <div class="half-width part1">
                <div class="container login-container">
                    <div class="row mb-5">
                        <img
                            src="/images/logo2.png"
                            class="logo"
                        />
                    </div>
                    <div class="row mb-5">
                        <form @submit.prevent="login">
                            <div class="mb-3">
                                <label for="" class="form-label">Correo:</label>
                                <input
                                    type="text"
                                    class="form-control shadow"
                                    name="email"
                                    id="email"
                                    v-model="form.email"
                                    placeholder="Ingrese su correo"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label"
                                    >Contraseña:</label
                                >
                                <input
                                    type="password"
                                    class="form-control shadow"
                                    name="password"
                                    v-model="form.password"
                                    id="password"
                                    required
                                />
                            </div>
                            <div class="text-end">
                                <button
                                    type="submit"
                                    class="btn btn-primary shadow"
                                >
                                    Ingresar
                                    <span
                                        v-if="isLoading == true"
                                        class="spinner-border spinner-border-sm"
                                        role="status"
                                        aria-hidden="true"
                                    ></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="half-width part2">
                <div class="text-container text-white">
                    <h1><b>Procesadora Leo Arzapalo</b></h1>
                    <h2><b>Lima - Perú</b></h2>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { setSwal } from "../../../Utils/swal.js";
export default {
    data() {
        return {
            isLoading: false,
            form: this.$inertia.form({
                email: "",
                password: "",
            }),
        };
    },
    mounted() {
        if (this.$page.props.autorizado) {
            this.autorizado = this.$page.props.autorizado;
        }
        if (this.autorizado == 1) {
            setSwal(4);
            this.autorizado = 0;
        }
    },
    methods: {
        login() {
            this.isLoading = true;
            this.form.post(`/login`, {
                onFinish: () => {
                    if (this.$page.props.noAuthoriced == true) {
                        setSwal(4);
                    }
                },
            });
        },
    },
};
</script>
<style scoped>
.background {
    z-index: 1;
    margin: 0;
}
.forehead {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 2;
    width: 100%;
    margin: 0;
}

.half-width {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}
.logo {
    width: 200px;
    margin: auto;
}
.btn-recomended {
    font-family: Open Sans Light, Open Sans, arial;
    cursor: pointer;
    margin: auto;
    z-index: 9999;
    box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
}
.btn-google {
    font-family: Open Sans Light, Open Sans, arial;
    cursor: pointer;
    z-index: 9999;
    margin: auto;
    background-color: #ffffff;
    box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
    border-color: rgb(184, 184, 184);
}
.btn-google:hover {
    background-color: #003bfc;
    color: white;
}
.btn-google img {
    border-radius: 3px;
    width: 25px;
    margin-right: 5px;
}
.text-container {
    width: 100%;
    background: linear-gradient(
        to right,
        #0c0c0cb5,
        #0c0c0c05,
        rgb(0 0 0 / 0%)
    );
    margin-top: auto;
    padding-left: 15px;
    padding-right: 15px;
}
.login-container {
    margin-top: auto;
    padding-bottom: 180px;
    padding-left: 120px;
    padding-right: 120px;
}
.part1 {
    width: 35%;
}
.part2 {
    width: 65%;
    background-color: #d82435;
    background: url(https://s3.amazonaws.com/arc-wordpress-client-uploads/infobae-wp/wp-content/uploads/2018/01/29121954/Jugos-12.jpg);
    background-repeat: repeat-x;
    background-size: cover;
    background-position-x: center;
    box-shadow: inset 5px -5px 20px 0px #5c5c5c;
}
.spinner-login {
    margin-left: 10px;
}
/* Login css mediasquerys  */
@media screen and (min-width: 2844px) {
    .login-container {
        padding-bottom: 400px;
        padding-left: 200px;
        padding-right: 200px;
    }
}
@media screen and (min-width: 2560px) {
    .login-container {
        padding-bottom: 400px;
        padding-left: 200px;
        padding-right: 200px;
    }
}
</style>
