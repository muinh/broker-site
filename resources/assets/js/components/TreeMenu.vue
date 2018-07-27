<template>
    <li class="menu-item" :class="liClass(baseNode)">
        <b-link :to="baseNode.url" class="menu-link" v-html="baseNode.title" exact></b-link>
        <!--<a :href="baseNode.url" class="menu-link" v-html="baseNode.title"></a>-->
        <ul v-if="baseNode.nodes.length > 0" class="sub-menu">
            <li is="tree-menu" v-for="node in nodes.nodes" :nodes="node.nodes" :baseNode="node" :depth="depth + 1" :key="node.id"></li>
        </ul>
    </li>
</template>
<script>
    export default {
        props: ['baseNode', 'nodes', 'depth'],
        name: 'tree-menu',
        methods: {
            liClass(baseNode) {
                return baseNode.class + (baseNode.nodes.length > 0 ? ' menu-item-has-children' : '');
            }
        }
    }
</script>