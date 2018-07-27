<template>
    <div v-html="page.content" class="fullScreen"></div>
</template>

<script>
    import LayoutHeader from "./layouts/LayoutHeader";
    import LayoutFooter from "./layouts/LayoutFooter";

    export default {
        props: ['page'],
        components: {LayoutFooter, LayoutHeader},
    }
</script>

<style scoped>
    .fullScreen {
        width: 100%;
        height: 100%;
    }
</style>