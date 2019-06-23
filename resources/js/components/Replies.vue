<template>
    <div>
        <div v-for="reply in items">
            <reply></reply>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        
        data() {
            return {
                items: this.data
            }
        }
    }
</script>