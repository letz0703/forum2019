<template>
    <div class="alert alert-warning" role="alert">
        <strong>Success! </strong> {{ body }}
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: 'temp message'
            }
        }
    }
</script>
