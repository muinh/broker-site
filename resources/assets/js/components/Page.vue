<template>
    <div class="body">
        <div class="content">
        <layout-header></layout-header>
        <section class="section page-header first-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="inner">
                            <h2 v-html="page.title"></h2>
                            <p>CFD Trading Platform</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section page-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <dynamic-content :content="page.content"></dynamic-content>
                    </div>
                </div>
            </div>
        </section>
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
        components: { DynamicContent,  LayoutFooter, LayoutHeader},
    }
</script>
