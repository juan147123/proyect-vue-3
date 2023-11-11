<template>
    <div class="sidebar">
        <div class="menu-btn">
            <i class="ph-bold ph-caret-left"></i>
        </div>
        <div class="d-flex flex-column align-items-center head">
            <div class="user-img">
                <img :src="$page.props.auth.user.avatar" alt="" />
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
export default {
    data() {
        return {
            showingNavigationDropdown: false,
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
