<template>
    <div>
        <div v-for="(reply, index) in replies" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <new-reply :endpoint='endpoint' @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';

    export default {

        components: { Reply, NewReply },

        data() {
            return {
                replies: [],
                endpoint: location.pathname + '/replies'
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(){
                axios.get(this.endpoint)
                     .then(this.refresh())
            },

            refresh(){
//                console.log(response);
                console.log('letz',response);
            },

            add(reply){
                this.replies.push(reply);
                this.$emit('added');
                flash('added');
            },

            remove(index){
                this.replies.splice(index, 1);
                this.$emit('removed')
                flash('deleted');
            }
        }
    }
</script>