<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
            <textarea name="body" id="body" class="form-control"
                      placeholder="Have something to say"
                      rows="5"
                      required
                      v-model="body"
            ></textarea>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" @click="addReply">Post</button>
                </div>
            </div>
        </div>
        <div v-else>
            <p style="text-align:center;">Please <a href="/login">login to participate</a></p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['endpoint'],

        data() {
            return {
                body: '',
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
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