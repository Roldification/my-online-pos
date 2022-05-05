<template>
    <div>
        <el-form ref="form" :model="form" :rules="rules">
            <el-form-item label="Fullname" prop="fullname">
                <el-input  v-model="form.fullname" ></el-input>
            </el-form-item>
            <el-form-item label="Username" prop="username">
                <el-input v-model="form.username"></el-input>
            </el-form-item>
            <el-form-item label="Email Address">
                <el-input v-model="form.emailaddress"></el-input>
            </el-form-item>
            <el-form-item label="Password" prop="password">
                <el-input v-model="form.password"></el-input>
            </el-form-item>
            <el-form-item label="Confirm Password" prop="confirmpassword">
                <el-input v-model="form.confirmpassword"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" plain @click="onSubmit">Save</el-button>
                <el-button>Cancel</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>


<script>
export default {
    data() {

        var checkConfirm = (rule, value, callback) => {
            if (value !== this.form.password) {
                callback(new Error('Confirm Password do not match'))
            } else callback()
        }

        return {
            form: {
                fullname: '',
                username: '',
                emailaddress: '',
                password: '',
                confirmpassword: '',
            },

            rules: {
                fullname: [
                    {required: true, message: 'Fullname should not be empty.', trigger: 'blur'}
                ],
                username: [
                    {required: true, message: 'Username should not be empty', trigger: 'blur'}
                ],
                password: [
                    {required: true, message: 'Password should not be empty', trigger: 'blur'}
                ],
                confirmpassword: [
                    {validator: checkConfirm}
                ]
            }
        }
    },

    methods: {
        onSubmit() {
            window.axios.post('api/create-user', this.form).then(res=>{
                console.log(res.data)
            })
        }
    }
}
</script>