<template>
    <div :id="'reply-'+id" class="card">
        <div class="card-header" :class="isBest?'bg-success text-white': 'bg-default'">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+reply.owner.name" v-text="reply.owner.name"></a>
                    said <span v-text="ago"></span>
                </h5>
                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">update</button>
                    <button class="btn btn-link btn-sm" @click="cancel" type="button">cancel</button>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>
        <div class="card-footer level" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-outline-dark btn-sm mr-1" @click="editing = true">
                    Edit
                </button>
                <button class="btn btn-danger btn-sm mr-1" @click="destroy">delete</button>
            </div>
            <button class="btn btn-primary btn-sm mr-1 ml-auto" @click="markBest"
                    v-show="! isBest"
            >Best Reply??
            </button>
        </div>
    </div>
</template>
<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                body: this.reply.body,
                id: this.reply.id,
                isBest: this.reply.isBest,
            };
        },

        created() {
            window.events.$on('best-reply-selected', id =>{
                this.isBest = (id === this.id);
            })
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow() + '...';
            },
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.reply.id, {
                    body: this.body,
                })
                     .catch(error =>{
                         flash(error.response.data, 'danger');
                         //                         this.body = this.reply.body;
                     });
                this.editing = false;

                flash('updated');
            },

            cancel() {
                this.editing = false;
                this.body = this.reply.body;
            },

            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);

                //                $(this.$el).fadeOut(100, () =>{
                //                    flash('your reply has been deleted');
                //                });
            },
            markBest() {
                if (! this.authorize("owns", this.reply.thread)){
                    return;
                }
                axios.post('/replies/' + this.reply.id + '/best');
                window.events.$emit('best-reply-selected', this.reply.id);
            }
        }
    }
</script>