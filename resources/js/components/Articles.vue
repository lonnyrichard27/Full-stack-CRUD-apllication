<template>
    <div>
        <h2>Articles</h2>
        <form @submit.prevent="addArticle" class="mb-4">
            <div class="form-group">
                <input type="text" name="" class="form-control" id="" placeholder="Title"
                v-model="article.title">
            </div>
             <div class="form-group">
                <textarea type="text" name="" class="form-control" id="" placeholder="Body"
                v-model="article.body"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- diasbles the utton if theres no previous page -->
                <li 
                v-bind:class="[{disabled: !pagination.prev_page_url}]"
                @click="fetchArticles(pagination.prev_page_url)"
                 class="page-item"><a class="page-link" href="#">Previous</a></li>
                  
                  <li class="page-item" disabled><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }} </a></li>
                
                <li 
                  v-bind:class="[{disabled: !pagination.next_page_url}]"
                @click="fetchArticles(pagination.next_page_url)"
                class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
        <div class="card card-body"
        v-for="article in articles" v-bind:key="article.id">
            <h3>{{ article.title}}</h3>
            <p>{{ article.body }}</p>
            <hr>
            <div class="d-flex ">
                <button @click="editArticle(article)" class="w-25 btn btn-warning float-right mr-3 text-white">Edit</button>
                <button @click="deleteArticle(article.id)" class="w-25 btn btn-danger float-right mr-3">Delete</button>
            </div>
           
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                articles: [],
                article: {
                    id: '',
                    title: '',
                    body: ''
                }, 
                article_id: '',
                pagination: {},
                edit: false
            }
        },

        // the created method runs when the page loads and its used to fetch articles from the database
        created() {
            this.fetchArticles();
        },

        methods: {
            // fetching the api with pagination
            fetchArticles(page_url) {
                let vm = this;
                page_url = page_url || '/api/articles'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.articles = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }

                this.pagination = pagination;
            },
            deleteArticle(id){
                if(confirm('Are you sure?')){
                    fetch(`api/article/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Article Removed');
                        this.fetchArticles
                    })
                    .catch(err => console.log(err));
                }
            },
           
            addArticle() {
                if(this.edit === false){
                    //add
                    fetch('api/article', {
                        method: 'post',
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '',
                        this.article.body = '',
                        alert('Article Added');
                        this.fetchArticles();
                    })
                    .catch (err => console.log(err));
                } else {
                    // update
                    fetch('api/article', {
                        method: 'put',
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '',
                        this.article.body = '',
                        alert('Article Updated');
                        this.fetchArticles();
                    })
                    .catch (err => console.log(err));
                }
            },
             editArticle(article){
                this.edit = true;
                this.article.id = article.id;
                this.article.artcile_id = article.id;
                this.article.title = article.title;
                this.article.body = article.body;
            },
        }
    }
</script>
