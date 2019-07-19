<template>
    <div :id="'reply-'+id" class="card">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name"></a>
                    said <span v-text="ago"></span>
                </h5>
                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <form action="">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">update</button>
                    <button class="btn btn-link btn-sm" @click="cancel" type="button">cancel</button>
                </form>
            </div>
            <div v-else v-text="body"></div>
        </div>
        <div class="card-footer level" v-if="canUpdate">
            <button class="btn btn-outline-dark btn-sm mr-1" @click="editing = true">
                Edit
            </button>
            <button class="btn btn-danger btn-sm" @click="destroy">delete</button>
        </div>
    </div>
</template>
<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['data'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                body: this.data.body,
                tempbody: '',
                id: this.data.id
            };
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow() + '...';
            },

            signedIn(){
                return window.App.signedIn;
            },

            canUpdate(){
                //                return true;
                return this.authorize(user => this.data.user_id == user.id);
                //                                return this.data.user_id == window.App.user.id
            }
        },

        methods: {
            update(){
                axios.patch('/replies/' + this.data.id, {
                    body: this.body,
                })
                     .catch(errors =>{
                         flash(errors.response.data, 'danger');
                         this.body = this.data.body;
                     });
                this.editing = false;
                this.tempbody = this.body;

                flash('updated');
            },

            cancel() {
                this.editing = false;
                this.body = this.tempbody;
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);

                //                $(this.$el).fadeOut(100, () =>{
                //                    flash('your reply has been deleted');
                //                });
            }
        }
    }
</script>