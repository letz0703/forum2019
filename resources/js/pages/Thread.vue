<script>
    import Replies from '../components/Replies.vue';
    import Subscriptions from '../components/Subscription.vue';

    export default {
        props: ['thread'],
        components: { Replies, Subscriptions },

        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                pinned: this.thread.pinned,
                title: this.thread.title,
                body: this.thread.body,
                form: {},
                editing: false,
            }
        },

        created() {
            this.resetForm();
        },

        methods: {
            toggleLock(){
                let uri = `/locked-threads/${this.thread.slug}`;
                axios[this.locked ? 'delete' : 'post'](uri);
                this.locked = ! this.locked ;
            },
            
            togglePin(){
                let uri = `/pinned-threads/${this.thread.slug}`;
                axios[this.pinned ? 'delete' : 'post'](uri);
                this.pinned = ! this.pinned ;

            },

            toggleEdit(){
                if (! this.locked){
                   this.editing = true;
                }
            },

            update() {
                axios.patch(location.pathname, this.form).then(() =>{
                    this.title = this.form.title;
                    this.body = this.form.body;
                    flash('Your thread has been updated')
                });
                this.editing = false;
            },

            resetForm() {
                this.form = {
                    'title': this.title,
                    'body' : this.body
                };

                this.editing = false;
            }


        },
    }
</script>