<template>
    <div>
        <el-form :model="item" label-width="100px" :label-position="'right'">
            <el-form-item label="Name">
                <el-input v-model="item.name"> </el-input>
            </el-form-item>
            <el-form-item label="Category">
              <el-select class="w-full" v-model="item.category" placeholder="" >
                <template v-slot:empty >
                  <div class="p-2 text-gray-400">
                    No Categories found.
                  </div>
                </template>
                <el-option v-for="itemx in categories" :key="itemx.id" :value="itemx.id" :label="itemx.name">

                </el-option>
            </el-select>
            </el-form-item>
            <div class="float-right">
              <el-button @click="dialogVisible = true" type="primary" icon="el-icon-circle-plus"></el-button>
            </div>
        </el-form>


        <!-- dialog for item categories management -->
        <el-dialog
          title="Manage Item Categories"
          :append-to-body="true"
          :visible.sync="dialogVisible"
          width="30%"
          >
          <manage-categories>

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
          categories: _.cloneDeep(JSON.parse(this.itemCategories))
      }
    }
}
</script>