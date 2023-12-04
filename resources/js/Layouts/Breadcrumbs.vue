<template>
    <Spinner v-if="isLoading == true"></Spinner>
    <div class="breadcrumbs">
        <a href="dashboard" class="text-white"  @click="handleMenuClick">
            <i class="icon ph-bold ph ph-gauge"></i> &nbsp;Panel</a
        >

        <a
            :href="breadcrumb.url"
            class="text-white"
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
