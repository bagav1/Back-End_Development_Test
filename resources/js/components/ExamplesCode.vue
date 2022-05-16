<template>
    <div>
        <h3 class="text-center">All Posts</h3><br />
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="post in posts" :key="post.id">
                    <td>{{ post.id }}</td>
                    <td>{{ post.title }}</td>
                    <td>{{ post.description }}</td>
                    <td>{{ post.created_at }}</td>
                    <td>{{ post.updated_at }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <router-link :to="{ name: 'edit', params: { id: post.id } }" class="btn btn-primary">Edit
                            </router-link>
                            <button class="btn btn-danger" @click="deletePost(post.id)">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    data() {
        return {
            posts: []
        }
    },
    created() {
        this.axios
            .get('http://localhost:8000/api/posts')
            .then(response => {
                this.posts = response.data;
            });
    },
    methods: {
        deletePost(id) {
            this.axios
                .delete(`http://localhost:8000/api/post/delete/${id}`)
                .then(response => {
                    let i = this.posts.map(item => item.id).indexOf(id); // find index of your object
                    this.posts.splice(i, 1)
                });
        }
    }
}
</script>

<!-- --------------------------------------------------------------------------------------------- -->

<template>
    <div>
        <h3 class="text-center">Add Post</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addPost">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="post.title">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="post.description">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Post</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                post: {}
            }
        },
        methods: {
            addPost() {
                this.axios
                    .post('http://localhost:8000/api/post/add', this.post,{headers: {/*'Authorization': `Bearer ${localStorage.getItem("token")}`*/}})
                    .then(response => (
                        this.$router.push({name: 'home'})
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>

<!-- --------------------------------------------------------------------------------------------- -->

<template>
    <div>
        <h3 class="text-center">Edit Post</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updatePost">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="post.title">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="post.description">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                post: {}
            }
        },
        created() {
            this.axios
                .get(`http://localhost:8000/api/post/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.post = response.data;
                    // console.log(response.data);
                });
        },
        methods: {
            updatePost() {
                this.axios
                    .post(`http://localhost:8000/api/post/update/${this.$route.params.id}`, this.post)
                    .then((response) => {
                        this.$router.push({name: 'home'});
                    });
            }
        }
    }
</script>
