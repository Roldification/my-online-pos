<template>
    <div class="w-1/2">
        <div v-if="!isEditing">
            <table class="">
            <tr>
                <td>Name: </td>
                <td class="text-gray-500">{{displayItemData.name}}</td>
            </tr>
            <tr>
                <td>Category: </td>
                <td class="text-gray-500">{{displayItemData.subcategories.categories.name}}</td>
            </tr>
            <tr>
                <td>Sub-category: </td>
                <td class="text-gray-500">{{displayItemData.subcategories.name}}</td>
            </tr>
        </table>
        </div>

        <div v-else>
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
                </el-form-item>
            </el-form>
        </div>

        <div class="flex flex-row mt-5">
            <div v-if="!isEditing">
                <el-button size="small" @click="editDetails">Update</el-button>
            </div>
            <div v-else>
                <el-button size="small" class="grow" @click="onSubmit">Save</el-button>
                <el-button size="small" class="grow" @click="cancelEdit">Cancel</el-button>
            </div>
        </div>

        <!-- uom settings -->
        <div class="panel border-2 rounded-md mt-5">
            <div class="panel-header bg-blue-600 rounded-t-md px-2 py-1 text-white text-sm">
                Unit of Measurements for {{displayItemData.name}}
            </div>
            <div class="panel-body p-5">
                <table class="text-left">
                    <thead>
                        <tr>
                          <th class="border border-dashed p-2">UOM</th>
                          <th class="border border-dashed p-2">
                             <el-tooltip class="item" content="How many Base UOM (Unit Of Measurement) does this UOM constitutes" placement="top-start">
                                <span>count</span>
                             </el-tooltip>
                          </th>
                          <th class="border border-dashed p-2">Is Base?</th>
                          <th v-if="isEditingUOM" class="border border-dashed p-2">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(row, index) in displayItemData.item_attributes.uoms" :key="index">
                        <td class="border border-dashed p-2">
                          <span v-if="!isEditingUOM">{{row.uom}}</span>
                          <el-input v-else v-model="row.uom"> </el-input>
                        </td>
                        <td class="border border-dashed p-2">
                          <span v-if="!isEditingUOM">{{row.min_uom_count}}</span>
                          <div v-else style="width:100px;">
                              <el-input v-model="row.min_uom_count"> </el-input>
                          </div>
                        </td>
                        <td class="border border-dashed p-2">{{row.is_base ? 'Yes' : 'No'}}</td>
                      </tr>
                      <tr class="bg-blue-100" v-if="isEditingUOM">
                          <td class="border border-dashed p-2">
                              <el-input v-model="newUOMValue.uom"> </el-input>
                          </td>
                          <td class="border border-dashed p-2">
                              <div style="width:100px;">
                                  <el-input v-model="newUOMValue.min_uom_count"> </el-input>
                              </div>
                          </td>
                          <td class="border border-dashed p-2">No</td>
                          <td class="border border-dashed p-2"><el-button type="success" icon="el-icon-check" circle @click="addNewUOM"></el-button></td>
                      </tr>
                    </tbody>
                </table>

                <div class="flex flex-row mt-5">
                    <div v-if="!isEditingUOM">
                        <el-button size="small" @click="isEditingUOM=true">Update</el-button>
                    </div>
                    <div v-else>
                        <el-button size="small" class="grow" @click="updateUOM">Save</el-button>
                        <el-button size="small" class="grow" @click="isEditingUOM=false">Cancel</el-button>
                    </div>
                </div>
            </div>
          </div>
        <!-- end of uom settings -->
    </div>
</template>

<script>
import _ from 'lodash'

export default {
    props: ['itemData', 'defaultSubcategories', 'categoriesList'],
    data () {
        return {
          displayItemData: _.cloneDeep(this.itemData),
          isEditing: false,
          isEditingUOM: false,
          item: {
            name: this.itemData.name,
            category: this.itemData.subcategories.categories.id,
            sub_category_id: this.itemData.subcategories.id,
          },
          categories: _.cloneDeep(this.categoriesList),
          subcategories: _.cloneDeep(this.defaultSubcategories),
          isSubcategoryLoading: false,
          latestSubcategories: _.cloneDeep(this.defaultSubcategories),
          latestItem: {
            name: this.itemData.name,
            category: this.itemData.subcategories.categories.id,
            sub_category_id: this.itemData.subcategories.id,
          }, // --> this will occur when edit cancellation is done or new update for item has pushed through
          newUOMValue: {
            uom: null,
            is_base: false,
            min_uom_count: null
          },
        }
    },

    methods: {
        loadSubCategories () {
        let vm = this
        this.isSubcategoryLoading = true
        window.axios.get('api/get-subcategories', {
          params: {
            id: this.item.category
          }
        }).then((result) => {
          if (result.data.subcategories.length) {
            vm.item.sub_category_id = null
            vm.subcategories = result.data.subcategories
          } else {
            vm.item.sub_category_id = null
            vm.subcategories = []
          }

        }).catch((err) => {
          
        }).finally(()=>{
          vm.isSubcategoryLoading = false
        });
      },

      editDetails () {
        this.isEditing = true
      },

      cancelEdit () {
        this.subcategories = _.cloneDeep(this.latestSubcategories)
        this.item = _.cloneDeep(this.latestItem)
        this.isEditing = false
      },

      onSubmit () {
        let vm = this
        this.item.id = this.itemData.id
        window.axios.post('update-item', this.item).then(result=>{
          let res = result.data
          if (res.status=='ok') {
            vm.displayItemData.name = vm.item.name

            let categories = _.find(vm.categories, (o)=> {return o.id == vm.item.category})
            let subcategories = _.find(vm.subcategories, (o)=> {return o.id == vm.item.sub_category_id})
            
            console.log(categories, subcategories)

            vm.displayItemData.subcategories.categories.name = categories.name
            vm.displayItemData.subcategories.name = subcategories.name
            vm.latestSubcategories = _.cloneDeep(vm.subcategories)
            vm.latestItem = _.cloneDeep(vm.item)
          }
        })
        .catch(err=>console.log(err))
        .finally(()=>{
            vm.isEditing = false
        })
      },

      addNewUOM () {
        this.displayItemData.item_attributes.uoms.push(this.newUOMValue)
        this.newUOMValue = {
            uom: null,
            is_base: false,
            min_uom_count: null
        }
      },

      updateUOM () {
        window.axios.post('/update-uom', {id: this.itemData.id, uoms: this.displayItemData.item_attributes.uoms}).then(result=>{
          console.log(result.data)
        }).catch(err=>console.log(err))
      }
    }
}
</script>