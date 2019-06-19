<template>
    <div>
        <button type="submit" class="btn btn-default btn-sm" @click="toggle">
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
                favoritesCount: this.reply.favoritesCount,
            }
        },
        methods: {
            toggle() {
                if (this.isFavorite){
                    axios.delete('/replies/' + this.reply.id + '/favorites'); // delete Favorite
                } else{
                    axios.post('/replies' + this.reply.id + '/favorites');
                }
            }
        }
    }
</script>