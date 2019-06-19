<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['attributes'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                body: this.attributes.body,
                tempbody: ''
            };
        },

        methods: {
            update(){
                axios.patch('/replies/' + this.attributes.id, {
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
                axios.delete('/replies/' + this.attributes.id);
                $(this.$el).fadeOut(100, () =>{
                    flash('your reply has been deleted');
                });
            }
        }
    }
</script>