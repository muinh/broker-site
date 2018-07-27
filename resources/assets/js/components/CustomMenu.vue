<template>
    <ul>
        <tree-menu :depth="0" :nodes="node" v-for="node in nodes" :key="node.id" :baseNode="node"></tree-menu>
    </ul>
</template>

<script>
    import TreeMenu from "./TreeMenu";

    export default {
        components: {TreeMenu},
        name: "custom-menu",
        props: ['menuName'],
        data() {
            return {
                nodes: []
            }
        },
        mounted() {
            this.getMenu(this.menuName);
        },
        methods: {
            getMenu(name) {
                axios.get(`/api/menu/${name}`).then(response => {
                    this.nodes = response.data.menu_items;
                    this.$emit('loaded');
                });
            }
        }
    }
</script>