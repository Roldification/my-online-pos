<template>
    <div>
        <slot name="selectedCategory" :model="form" label-width="120px"> </slot>
        <el-form ref="form">
            <el-form-item label="Subcategory Name">
              <el-input v-model="form.subcategory_name"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button class="float-right" type="primary" @click="onSubmit">Add</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
export default {
    props: ['categoryId'],
    data () {
        return {
            form: {
                category_id: this.categoryId,
                subcategory_name: '',
            }
        }
    },

    watch: {
        categoryId: {
            handler: function (newVal, oldVal) {
                this.form.category_id = newVal
            }
        }
    },

    methods: {
        onSubmit () {
            window.axios.post('api/save-item-subcategory', this.form).then(res=>{
                let retval = res.data
                if (retval.status) {
                    this.$emit('doneAdd', retval.message)
                }
            })
        }
    }
}
</script>