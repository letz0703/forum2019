<template>
    <div>
        <button type="submit" :class="classes" @click="toggle">
            <i class="fas fa-heart"></i>
            <span v-text="count"></span>
        </button>
    </div>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited,
            }
        },
        computed: {
            classes() {
                return ['btn', 'btn-sm', this.active ? 'btn-primary' : 'btn-outline-dark'];
            },
            endpoint() {
                return '/replies/' + this.reply.id + '/favorites'
            }
        },
        methods: {
            toggle() {
                this.active ? this.unfavorite() : this.favorite();
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
                this.active = false;
                this.count--;
            },

            favorite() {
                axios.post(this.endpoint);
                this.active = true;
                this.count++;
            }
        }
    }
</script>
