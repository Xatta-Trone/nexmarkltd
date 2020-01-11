<template>
    <span class="cart-number"> {{ cartTotal }}</span>
</template>

<script>
export default {
    mounted() {
        // console.log("Component mounted.");
    },
    computed: {
        // count() {
        //     return this.$store.state.count;
        // },
        cartTotal() {
            return this.$store.getters.totalCartItem;
        }
    }
};
</script>
<style scoped>
span {
    color: #000;
    font-size: 20px;
}
</style>
