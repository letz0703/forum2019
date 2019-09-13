<script>
    import Replies from '../components/Replies.vue';
    import Subscriptions from '../components/Subscription.vue';

    export default {
        props: ['dataRepliesCount','dataLocked'],
        components: { Replies, Subscriptions },

        data() {
            return {
                repliesCount: this.dataRepliesCount,
                locked: this.dataLocked
            }
        }
    }
</script>