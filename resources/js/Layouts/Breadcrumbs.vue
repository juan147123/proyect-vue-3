<template>
    <Spinner v-if="isLoading == true"></Spinner>
    <div class="breadcrumbs text-dark">
        <a href="dashboard"  @click="handleMenuClick">
            <i class="icon ph-bold ph ph-gauge"></i> &nbsp;Panel</a
        >

        <a
            :href="breadcrumb.url"
            v-for="breadcrumb in this.modules"
            @click="handleMenuClick"
            ><span class="separator"> > </span
            ><i :class="'icon ph-bold ph ' + breadcrumb.icon"></i> &nbsp;{{
                breadcrumb.label
            }}</a
        >
    </div>
</template>
<script>
import Spinner from "@/Layouts/Preloader.vue";
export default {
    props: ["modules"],
    components: {
        Spinner,
    },
    data() {
        return {
            isLoading: false,
        };
    },
    methods: {
        handleMenuClick() {
            this.isLoading = true;
        },
    },
};
</script>
