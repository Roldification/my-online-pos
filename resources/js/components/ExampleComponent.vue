<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Welcome {{currentUser.name}}!</div>

                    <div class="card-body">
                        To begin with, let's create a new Store for you!

                        <div class="mt-8 w-1/2">
                            <el-form ref="form" name="myForm" :model="storeData" label-width="120px" method="post" action="/store-store">
                                <div v-html="csrfToken" />
                                <el-form-item label="Store Name">
                                    <el-input v-model="storeData.name" name="name"></el-input>
                                </el-form-item>
                                <el-form-item label="Slug">
                                    <el-input v-model="storeData.slug" name="slug"></el-input>
                                </el-form-item>
                                <el-form-item>
                                    <el-button type="primary" @click="onSubmit" plain>Create Store!</el-button>
                                </el-form-item>
                            </el-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'csrfToken',
            'user'
        ],
        data () {
            return {
                currentUser: JSON.parse(this.user),
                storeData: {
                    name: '',
                    slug: '',
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
            window.axios.get('http://localhost:8000/').then(res=>{
                console.log(res.data)

            })
        },

        methods: {
            onSubmit() {
                this.$confirm('Save New Store?', 'Confirmation', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'success'
                }).then(() => {
                   document.myForm.submit();
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
            }
        }
    }
</script>
