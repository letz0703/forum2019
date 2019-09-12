<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>
        <paginator :dataSet="dataSet" @updated="fetch"></paginator>
        <new-reply @created="add" v-if="! $parent.locked"></new-reply>
        <p v-else style="text-align: center">
            This thread is locked
        </p>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    import collection from '../mixins/collection.vue';

    export default {

        components: { Reply, NewReply },

        mixins: [collection],

        data() {
            return {
                dataSet: false,
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page){
                axios.get(this.url(page))
                     .then(this.refresh);
            },

            url(page) {
                if (! page){
                    let query = location.search.match(/page=(\d+)/);
                    page = query ? query[1] : 1;
                }
                //                return location.pathname+'/replies?page='+page;
                return `${location.pathname}/replies?page=${page}`
            },

            refresh({ data }){
                this.dataSet = data;
                this.items = data.data;
                window.scrollTo(0, 0);
                //                console.log(response);
                //                console.log(data);
            },

        }
    }
</script>