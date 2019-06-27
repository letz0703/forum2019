<script>
    export default {

        data() {
            return {
                items: []
            }
        },

        methods: {
            add(item){
                this.items.push(item);
                this.$emit('added');
                flash('added');
            },

            remove(index){
                this.items.splice(index, 1);
                this.$emit('removed')
                flash('deleted');
            }
        },
    }
</script>