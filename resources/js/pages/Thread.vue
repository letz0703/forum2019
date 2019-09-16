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
            }
        },

        methods: {
            toggleLock(){
                let uri = `/locked-threads/${this.thread.slug}`;
                this.locked = ! this.locked ;
                axios[this.locked ? 'delete' : 'post'](uri);
            },
            togglePin(){
                let uri = `/pinned-threads/${this.thread.slug}`;
                this.pinned = ! this.pinned ;
                axios[this.pinned ? 'delete' : 'post'](uri);
            }
        },
    }
</script>