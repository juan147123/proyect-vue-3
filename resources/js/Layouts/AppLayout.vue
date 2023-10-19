<template>
    <Spinner v-if="isLoading == true"></Spinner>
    <Sidebar
        @menu-click="handleMenuClick"
        @tiempo-click="registrarTiempoDeUso"
    />
    <Navbar @menu-click="handleMenuClick" />
    <main>
        <slot />
    </main>
</template>
<script>
import Navbar from "../LayoutComponent/Navbar.vue";
import Spinner from "@/Layouts/Preloader.vue";
import Sidebar from "../LayoutComponent/Sidebar.vue";
export default {
    components: {
        Navbar,
        Sidebar,
        Spinner,
    },
    data() {
        return {
            isLoading: false,
        };
    },
    mounted() {
        $(".menu > ul > li").click(function (e) {
            $(this).siblings().removeClass("active");
            $(this).toggleClass("active");
            $(this).find("ul").slideToggle();
            $(this).siblings().find("ul").slideUp();
            $(this).siblings().find("ul").find("li").removeClass("active");
        });

        $(".menu-btn").click(function (e) {
            $(".sidebar").toggleClass("active");
            $(".navbar").toggleClass("active");
            $(".main-content").toggleClass("active");
            $(".breadcrumbs").toggleClass("active");
            $(".main-content-dashboard").toggleClass("active");
            $(".user-img").toggleClass("active");
            $(".nav").toggleClass("active");
        });
    },
    methods: {
        handleMenuClick() {
            this.isLoading = true;
        },
    },

    computed: {
      
    },
};
</script>
