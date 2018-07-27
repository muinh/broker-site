<script>
    export default {
        name: "dynamic-content",
        props: ['content'],
        render(h) {
            return h(Vue.compile(this.content))
        }
    }
</script>