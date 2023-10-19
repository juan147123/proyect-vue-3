<template>
    <div class="navbar">
        <div class="logo">
           
        </div>

        <div class="row container-data">
           
        </div>
    </div>
</template>
<script>
export default {
    emits:["menu-click"],
    data() {
        return {
            unidades: [],
            cecos: [],
            selectedOption: "",
            selectedOptionUND: "",
            selectedOptionCECO: "",
            loadSelect: false,
        };
    },
    mounted() {
       
    },
    methods: {
        handleMenuClick() {
            this.$emit("menu-click");
        },
        logout() {
            this.$inertia.post(route("logout"));
        },

    },
};
</script>
<style scoped>
.container-data {
    width: 700px;
}
#radiosGRC label {
    font-size: 12px;
}

.selects select {
    height: 30px;
    font-size: 12px;
    margin-top: -5px;
}
.selects select option {
    font-size: 12px;
}
</style>
