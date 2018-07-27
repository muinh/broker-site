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
                        <b-tabs>
                            <b-tab v-for="tab in page.tabs" :title="tab.name" :key="tab.id">
                                <div role="tablist">
                                    <b-card no-body v-for="(item, key) in tab.tab_items" :key="item.id" class="tab-card">
                                        <div class="card-header p-0 border-bottom-0">
                                            <h5 class="mb-0">
                                                <b-btn block href="#" v-b-toggle="'accordion' + item.id" variant="info">{{item.name}}</b-btn>
                                            </h5>
                                        </div>
                                        <b-collapse :id="'accordion' + item.id" :visible="key === 0" :accordion="tab.name" role="tabpanel">
                                            <b-card-body>
                                                <p class="card-text" v-html="item.content"></p>
                                            </b-card-body>
                                        </b-collapse>
                                    </b-card>
                                </div>
                            </b-tab>
                        </b-tabs>
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

    export default {
        props: ['page'],
        components: {LayoutFooter, LayoutHeader},
    }
</script>

<style scoped>
</style>
