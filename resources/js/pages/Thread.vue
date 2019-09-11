<script>
    import Replies from '../components/Replies.vue';
    import Subscriptions from '../components/Subscription.vue';

    export default {
        props: ['initialRepliesCount'],
        components: { Replies, Subscriptions },

        data() {
            return {
                repliesCount: this.initialRepliesCount,
                locked: false
            }
        }
    }
</script>