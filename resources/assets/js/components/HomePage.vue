<template>
    <div class="body">
        <div class="content">
            <layout-header></layout-header>
            <dynamic-content :content="page.content"></dynamic-content>
        </div>
        <layout-footer></layout-footer>
    </div>
</template>

<script>
    import LayoutHeader from "./layouts/LayoutHeader";
    import LayoutFooter from "./layouts/LayoutFooter";
    import DynamicContent from "./common/DynamicContent";

    export default {
        props: ['page'],
        components: {DynamicContent, LayoutFooter, LayoutHeader},
    }
</script>
