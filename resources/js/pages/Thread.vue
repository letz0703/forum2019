<script>
    import Replies from '../components/Replies.vue';
    import Subscriptions from '../components/Subscription.vue';

    export default {
        props: ['thread'],
        components: { Replies, Subscriptions },

        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked
            }
        },

        methods: {
            toggleLock(){
                this.locked = ! this.locked ;
                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);
            }
        },
    }
</script>