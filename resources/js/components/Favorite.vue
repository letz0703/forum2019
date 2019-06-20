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
                isFavorited: this.reply.isFavorited,
            }
        },
        computed: {
            classes() {
                return ['btn', 'btn-sm', this.isFavorited ? 'btn-primary' : 'btn-outline-dark'];
            },
            endpoint() {
                return '/replies/' + this.reply.id + '/favorites'
            }
        },
        methods: {
            toggle() {
                this.isFavorited ? this.unfavorite() : this.favorite();
                //                if (this.isFavorited){
                //                    this.unfavorite();
                //
                //                } else{
                //                    this.favorite();
                //
                //                }
            },

            unfavorite() {
                axios.delete(this.endpoint); // delete Favorite
                this.isFavorited = false;
                this.favoritesCount--;
            },

            favorite() {
                axios.post(this.endpoint);
                this.isFavorited = true;
                this.favoritesCount++;
            }
        }
    }
</script>