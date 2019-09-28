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
                editing: false,
            }
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
            }
        },
    }
</script>