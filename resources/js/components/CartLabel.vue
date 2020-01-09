<template>
    <span>{{ count }}</span>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
    },
    computed: {
        count() {
            return this.$store.state.count;
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
