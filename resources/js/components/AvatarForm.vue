<template>
    <div>
        <h1 v-text="user.name">
            <!--<small>Since {{ $profileUser->created_at->diffForHumans() }}</small>-->
        </h1>

        <form v-if="canUpdate" method="POST"
              enctype="multipart/form-data"
              accept="image/*"
        >
            <input type="file" name="avatar" @change="onChange">
            <button type="submit">Add Avatar</button>
        </form>

        <img :src="avatar" width="50" height="50">

        <hr>

    </div>
</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {
                avatar: ''
            }
        },

        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            }
        },

        methods: {
            onChange(e) {
                if (! e.target.files.length) return;
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = e => {
//                    console.log(e);
                    this.avatar = e.target.result;
                }
            }
        }
    }
</script>