<template>
    <div class="sidebar">
        <div class="menu-btn">
            <i class="ph-bold ph-caret-left"></i>
        </div>
        <div class="d-flex flex-column align-items-center head">
            <div class="user-img" v-if="$page.props.auth.user.avatar">
                <img :src="$page.props.auth.user.avatar" alt="" />
            </div>
            <div class="user-img" v-else>
                <img :src="image" alt="" />
            </div>
        </div>
        <div class="user-details">
            <p class="title" style="text-align: center">
                {{ $page.props.auth.user.name }}
            </p>
            <p class="name" style="text-align: center">
                {{ $page.props.auth.user.name }}
            </p>
        </div>
        <div class="nav">
            <div class="menu">
                <p class="title">Menú</p>
                <ul>
                    <li :class="{ active: route().current('usuarios') }">
                        <a
                            @click="handleMenuClick"
                            :href="route('usuarios')"
                            :active="route().current('usuarios')"
                        >
                            <i class="ph ph-bold ph-users"></i>
                            <span class="text">Usuarios</span>
                        </a>
                    </li>
                    <li :class="{ active: route().current('proveedores') }">
                        <a
                            @click="handleMenuClick"
                            :href="route('proveedores')"
                            :active="route().current('proveedores')"
                        >
                            <i class="ph ph-bold ph-users"></i>
                            <span class="text">Proveedores</span>
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a>
                            <i class="ph-bold ph-gear-fine"></i>
                            <span class="text">Configuraciones</span>
                            <i class="arrow ph-bold ph-caret-down"></i>
                        </a>
                        <ul
                            class="sub-menu"
                            :class="{
                                active: route('configuraciones.redirect', [
                                    'categoria',
                                ]),
                            }"
                        >
                            <a
                                @click="handleMenuClick"
                                :href="
                                    route('configuraciones.redirect', [
                                        'categoria',
                                    ])
                                "
                            >
                                <span class="text">Categorias</span>
                            </a>
                            <a
                                @click="handleMenuClick"
                                :href="
                                    route('configuraciones.redirect', [
                                        'frutas',
                                    ])
                                "
                            >
                                <span class="text">Frutas</span>
                            </a>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="menu">
            <p class="title">Salir</p>
            <ul>
                <li @click="logout" class="logout">
                    <a>
                        <i class="icon ph-bold ph-sign-out"></i>
                        <span class="text">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
var urlBase = window.location.origin;
export default {
    data() {
        return {
            showingNavigationDropdown: false,
            image: urlBase + "/images/default-user.jpg",
        };
    },
    mounted() {},

    methods: {
        handleMenuClick() {
            this.$emit("menu-click");
        },

        async logout() {
            this.$inertia.post(route("logout"));
        },
    },

    computed: {
        path() {
            return window.location.pathname;
        },
    },
};
</script>
<style scoped>
.logout {
    cursor: pointer;
}
</style>
