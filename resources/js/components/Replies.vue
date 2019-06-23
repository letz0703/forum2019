<template>
    <div>
        <div v-for="reply in items">
            <reply :data="reply"></reply>
        </div>
    </div>
</template>

<script>
    import Reply from './Reply.vue';

    export default {
        props: ['data'],
        components: { Reply },

        data() {
            return {
                items: this.data
            }
        }
    }
</script>