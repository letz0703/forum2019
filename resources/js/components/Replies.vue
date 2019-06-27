<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <new-reply :endpoint='endpoint' @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    import collection from '../mixins/collection.vue';

    export default {

        components: { Reply, NewReply },

        mixins: [ collection ],

        data() {
            return {
                dataSet: false,
                items: [],
                endpoint: location.pathname + '/replies'
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(){
                axios.get(this.endpoint)
                     .then(this.refresh);
            },

            refresh({ data }){
                this.dataSet = data;
                this.items = data.data;
                //                console.log(response);
                //                console.log(data);
            },

        }
    }
</script>