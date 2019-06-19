<template>
    <div>
        <button type="submit" class="btn btn-default btn-sm">
            <i class="fas fa-heart"></i>
            <span v-text="favoritesCount"></span>
        </button>
    </div>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                favoritesCount: 0

            }
        }
    }
</script>