<template>
    <div>
        <el-form name="myForm" :model="form" status-icon ref="ruleForm" label-width="120px" class="demo-ruleForm" method="post" action="/login">
             <div v-html="csrfToken">

             </div>
             <el-form-item label="Email" prop="email">
                <el-input type="text" v-model="form.email" name="email"></el-input>
            </el-form-item>
            <el-form-item label="Password" prop="password">
                <el-input type="text" v-model="form.password" name="password"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="processLogin" plain>Submit</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
export default {
    props: ['csrfToken', 'oldemail', 'oldpassword'],
    data() {
        return {
            form: {
                email: this.oldemail !== '' ? this.oldemail : '',
                password: this.oldpassword !== '' ? this.oldpassword : '',
            }
        }
    },

    methods: {
        processLogin () {
            // window.axios.post('login', this.form).then(res=>{
            //     console.log(res.data)
            // })
          document.myForm.submit();
        }
    }
}
</script>