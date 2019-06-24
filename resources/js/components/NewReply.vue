<template>
    <div>
        <!--@if ( auth()->check())-->
        <div class="form-group">
            <textarea name="body" id="body" class="form-control"
                      placeholder="Have something to say"
                      rows="5"
            required
            v-model="body"
            ></textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-primary" @click="addReply">Post</button>
        </div>
        <!--@else-->
        <!--<p style="text-align:center;">Please <a href="{{ route('login') }}">login to participate</a></p>,-->
        <!--@endif-->
    </div>
</template>

<script>
    export default {
        props: [''],

        data() {
            return {
                body: '',
                endpoint: '/threads/quis/19/replies '
            }
        },

        methods: {
            addReply() {
                axios.post(this.endpoint, { body: this.body })
                     .then(data =>{
                         this.body = '';
                         flash('reply has been posted');
                         this.$emit('created', data.data);
                     });
            }
        }
    }
</script>