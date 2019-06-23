<template>
        <div :id="'reply-'+id" class="card">
            <div class="card-header">
                <div class="level">
                    <h5 class="flex">
                        <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name"></a>
                        said {{ data.created_at }}
                    </h5>
                    <!--@if ( auth()->check() )-->
                    <!--<div>-->
                        <!--<favorite :reply = " {{ $reply }}"></favorite>-->
                    <!--</div>-->
                    <!--@endif-->
                </div>
            </div>
            <div class="card-body">
                <div v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" @click="update">update</button>
                    <button class="btn btn-link btn-sm" @click = "cancel">cancel</button>
                </div>
                <div v-else v-text="body"></div>
            </div>
            <!--@can('update')-->
            <div class="card-footer level">
                <button class="btn btn-outline-dark btn-sm mr-1" @click="editing = true">
                    Edit
                </button>
                <button class="btn btn-danger btn-sm" @click="destroy">delete</button>
            </div>
            <!--@endcan-->
        </div>
</template>
<script>
    import Favorite from './Favorite.vue';

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

        methods: {
            update(){
                axios.patch('/replies/' + this.data.id, {
                    body: this.body,
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