<template>
    <div class="container">
            <div class="search-panel">
                <div class="search-panel__results">

                    <ais-refinement-list attribute="channel.name"></ais-refinement-list>
                    <ais-hits>
                        <div slot="item" slot-scope="{ item }">
                            <a :href="item.path">
                                <ais-highlight :hit="item" attribute="title"/>
                            </a>
                        </div>
                    </ais-hits>

                    <div class="pagination">
                        <ais-pagination/>
                    </div>
                </div>
            </div>
        </ais-instant-search>
    </div>
</template>


<script>
    import algoliasearch from 'algoliasearch/lite';
    import 'instantsearch.css/themes/algolia-min.css';

    export default {
        data(){
            return {
                searchClient: algoliasearch(
                ),
            };
        },
    };
</script>

<style>
    /*body {*/
    /*    font-family: sans-serif;*/
    /*    padding: 1em;*/
    /*}*/

    .ais-Highlight-highlighted {
        background: cyan;
        font-style: normal;
    }

    /*.header {*/
    /*    display: flex;*/
    /*    align-items: center;*/
    /*    min-height: 50px;*/
    /*    padding: 0.5rem 1rem;*/
    /*    background-image: linear-gradient(to right, #4dba87, #2f9088);*/
    /*    color: #fff;*/
    /*    margin-bottom: 1rem;*/
    /*}*/

    /*.header a {*/
    /*    color: #fff;*/
    /*    text-decoration: none;*/
    /*}*/

    /*.header-title {*/
    /*    font-size: 1.2rem;*/
    /*    font-weight: normal;*/
    /*}*/

    /*.header-title::after {*/
    /*    content: ' ▸ ';*/
    /*    padding: 0 0.5rem;*/
    /*}*/

    /*.header-subtitle {*/
    /*    font-size: 1.2rem;*/
    /*}*/

    /*.container {*/
    /*    max-width: 1200px;*/
    /*    margin: 0 auto;*/
    /*    padding: 1rem;*/
    /*}*/
    
    .search-panel {
        display: flex;
    }

    .search-panel__filters {
        flex: 1;
        margin-right: 1em;
    }

    .search-panel__results {
        flex: 3;
    }

    .searchbox {
        margin-bottom: 2rem;
    }

    .pagination {
        margin: 2rem auto;
        text-align: center;
    }
</style>
