<template>
    <div v-if="signedIn">
        <button :class="classes" @click="subscribe" v-text="subscriptionText"></button>
    </div>
</template>

<script>
    export default {
        props: ['active'],

        data() {
            return {
                endpoint: location.pathname + '/subscriptions',
            }
        },

        computed: {
            classes() {
                return ['btn btn-sm', this.active ? 'btn-primary' : 'btn-danger'];
            },

            signedIn() {
                return window.App.signedIn;
            },

            subscriptionText(){
                return this.active? 'unsubscribe' : 'subscribe';
            }
        },

        methods: {
            subscribe(){
                axios[(this.active ? 'delete' : 'post')](this.endpoint);
                this.active = !this.active;
            }
        },
    }
</script>
