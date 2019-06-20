<template>
    <div>
        <button type="submit" :class="classes" @click="toggle">
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
                isFavorited: false,
            }
        },
        computed : {
            classes() {
                return ['btn', this.isFavorited ? 'btn-primary': 'btn-default'];
            }
        },
        methods: {
            toggle() {
                if (this.isFavorited){
                    axios.delete('/replies/' + this.reply.id + '/favorites'); // delete Favorite
                } else{
                    axios.post('/replies/' + this.reply.id + '/favorites');
                    this.isFavorited = true;
                    this.favoritesCount++;
                }
            }
        }
    }
</script>