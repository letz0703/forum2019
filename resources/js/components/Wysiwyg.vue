<template>
    <div>
        <input id="trix" type="hidden" :name="name" :value="value">
        <trix-editor ref="trix" input="trix"></trix-editor>
    </div>
</template>

<script>
    export default {
        props: ['name', 'value'],

        mounted(){
            this.$refs.trix.addEventListener('trix-change', e => {
                console.log('Handling');
                this.$emit('input', e.target.innerHTML);
            });
        },

        data(){
            return {}
        },
    }
</script>

