<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <wysiwyg name="body" v-model="body" placeholder="Have something to say?"
                         ref="trix"
                         :shouldClear="completed"
                ></wysiwyg>
                <div>
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
    import 'jquery.caret';
    import 'at.js';

    export default {

        data() {
            return {
                body: '',
                completed: false
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON("/api/users", {name: query}, function(usernames) {
                            callback(usernames)
                        });
                    }
                }
            });

        },

        methods: {
            addReply() {
                axios.post(location.pathname+'/replies', { body: this.body })
                     .catch(error => {
                         flash(error.response.data,'danger');
                     })
                     .then(({data}) =>{
                         this.body = '';
                         this.completed = true;
                         flash('reply has been posted');
                         // this.$refs.trix.$refs.trix.value = '';
                         this.$emit('created', data);
                     });
            }
        }
    }
</script>
