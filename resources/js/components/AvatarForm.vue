<template>
    <div>
        <div class="level">
            <img :src="avatar" width="50" height="50" class="mr-1">
            <h1 v-text="user.name"></h1>
            <small v-text="reputation"></small>
        </div>

        <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
            <image-upload name="avatar" class="mr-1" @loaded="onLoad"></image-upload>
        </form>
        <hr>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';
    export default {
        props: ['user'],

        components: { ImageUpload },

        data() {
            return {
                avatar: this.user.avatar_path
            }
        },

        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            },
            reputation() {
                return this.user.reputation+'xp';
            }
        },

        methods: {
            onLoad(avatar){
                this.avatar = avatar.src
                this.persist(avatar.file)
            },

            persist(file) {
                let data = new FormData();
                data.append('avatar', file)
                axios.post('/api/users/' + this.user.name + '/avatar', data)
                     .then(() => flash('Avatar Uploaded'));
            }
        }
    }
</script>