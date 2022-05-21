<template>
    <div>
       <el-form ref="form" :model="form" label-width="120px">
            <el-form-item label="Category Name">
              <el-input v-model="form.categoryName"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button class="float-right" type="primary" @click="onSubmit" :loading="isInserting">Add</el-button>
            </el-form-item>
       </el-form>

        <el-table
        :data="categories"
        :empty-text="'No Data Available'"
        :height="200"
        :size="'mini'"
        class="text-sm"
        style="width: 100%;">
            <el-table-column 
              prop="name"
              label="Name">
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
export default {
  props: ['storeId'],
  data () {
    return {
      form: {
        categoryName: '',
      },
      categories: [],
      isInserting: false,
    }
  },

  methods: {
    onSubmit () {
      this.isInserting = true
      let vm = this
      window.axios.post('api/save-item-category', {
        id: 2,
        name: this.form.categoryName
      }).then(res=>{
        let retval = res.data
        if (retval.status) {
          this.categories.push(retval.message)
        }

        vm.isInserting = false
      }).catch(err=>{
        vm.isInserting = false
      })
    }
  }
}
</script>