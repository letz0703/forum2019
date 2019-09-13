<template>
    <li class="nav-item dropdown" :class="{open: toggle}">
        <a href="#" class="nav-link dropdown-toggle"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false"
           @click.prevent="toggle = !toggle"
        >
            Channels <span class="caret"></span>
        </a>
        <div class="dropdown-menu channel-dropdown">
            <div class="input-wrapper">
                <input type="text"
                       class="form-control"
                       v-model="filter"
                       placeholder="Filter Channels..."
                />
            </div>
            <ul class="list-group channel-list">
                <li class="list-group-item" v-for="channel in filteredThreads">
                    <a :href="`/threads/${channel.slug}`" v-text="channel.name"></a>
                </li>
            </ul>
        </div>
    </li>
</template>

<style lang="scss">
    .channel-dropdown {
        padding: .5rem 1rem;
    }

    .channel-list {
        max-height: 400px;
        overflow: auto;
        margin-bottom: 0;

        .list-group-item {
            border-radius: 0;
            border-left: none;
            border-right: none;
        }
    }
</style>

<script>
    export default {
        props: ['channels'],

        data(){
            return {
                toggle: false,
                filter: '',
            }
        },

        computed: {
            },
        },
    }
</script>
