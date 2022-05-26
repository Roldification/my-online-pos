<template>
    <div>
        <el-form :model="item" label-width="110px" :label-position="'left'" class="text-sm">
            <el-form-item label="Name">
                <el-input v-model="item.name"> </el-input>
            </el-form-item>
            <el-form-item label="Category">
              <el-select class="w-full" v-model="item.category" placeholder="" @change="loadSubCategories">
                <template v-slot:empty >
                  <div class="p-2 text-gray-400">
                    No Categories found.
                  </div>
                </template>
                <el-option v-for="itemx in categories" :key="itemx.id" :value="itemx.id" :label="itemx.name">

                </el-option>
            </el-select>
             <el-button @click="dialogVisible = true" type="primary" icon="el-icon-circle-plus" class="float-right"></el-button>
            </el-form-item>

            <el-form-item label="Sub-Category">
              <el-select class="w-full" v-model="item.sub_category_id" placeholder="" :loading="isSubcategoryLoading" :loading-text="'loading...'">
                <template v-slot:empty >
                  <div class="p-2 text-gray-400">
                    No Sub-Categories found.
                  </div>
                </template>
                <el-option v-for="itemx in subcategories" :key="itemx.id" :value="itemx.id" :label="itemx.name">

                </el-option>
            </el-select>
             <el-button @click="dialogVisible = true" type="primary" icon="el-icon-circle-plus" class="float-right"></el-button>
            </el-form-item>

        </el-form>


        <!-- dialog for item categories management -->
        <el-dialog
          title="Manage Item Categories"
          :append-to-body="true"
          :visible.sync="dialogVisible"
          :destroy-on-close="true"
          width="30%"
          >
          <manage-categories @doneAdd="doneAdd">

          </manage-categories>
        </el-dialog>
        <!-- end of dialog for item categories management -->
    </div>
</template>


<script>
import _ from 'lodash'
export default {
    props: ['storeId', 'itemCategories'],
    data() {
      return {
          item: {
            name: '',
            category: null,
            sub_category_id: null,
            min_uom: '',
            item_attributes: {}
          },
          dialogVisible: false,
          categories: _.cloneDeep(JSON.parse(this.itemCategories)),
          subcategories: [],
          isSubcategoryLoading: false,
      }
    },

    methods: {
      doneAdd (data) {
        console.log(data)
        this.dialogVisible = false
        this.categories.push(data)
        this.item.category = data.id
      },

      loadSubCategories () {
        let vm = this
        this.isSubcategoryLoading = true
        window.axios.get('api/get-subcategories', {
          params: {
            id: this.item.category
          }
        }).then((result) => {
          if (result.data.subcategories.length) {
            vm.subcategories = result.data.subcategories
          } else {
            vm.item.sub_category_id = null
            vm.subcategories = []
          }

        }).catch((err) => {
          
        }).finally(()=>{
          vm.isSubcategoryLoading = false
        });
      }
    }
}
</script>