<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['data'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                body: this.data.body,
                tempbody: ''
            };
        },

        methods: {
            update(){
                axios.patch('/replies/' + this.data.id, {
                    body: this.body,
                });
                this.editing = false;
                this.tempbody = this.body;

                flash('updated');
            },

            cancel() {
                this.editing = false;
                this.body = this.tempbody;
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);
                $(this.$el).fadeOut(100, () =>{
                    flash('your reply has been deleted');
                });
            }
        }
    }
</script>