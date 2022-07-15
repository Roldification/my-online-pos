<template>
    <div>
        <el-table
            :data="gridPO"
        >
            <el-table-column
             prop="item"
             label="Item"
             width="250"
            >
                <template slot-scope="scope">
                    <el-select
                        v-show="scope.row.isEditingItem"
                        v-model="scope.row.item"
                        placeholder="Select Item"
                        @change="doneUpdateItem(scope.row)"
                    >
                        <el-option
                        v-for="item in items" :key="item.id"
                        :label="item.name"
                        :value="item.id"
                        >

                        </el-option>
                    </el-select>
                    <span v-show="!scope.row.isEditingItem" @click="updateItem(scope.row)">
                        <span v-if="scope.row.item == null">
                            -
                        </span>
                        <span v-else>
                            {{ getItemName(scope.row.item) }}
                        </span>
                    </span>
                </template>
            </el-table-column>

             <el-table-column
             prop="quantity"
             label="Quantity"
             width="80"
            >
                <template slot-scope="scope">
                    <el-input :id="'qtyInput'+scope.row.rowId" v-show="scope.row.isEditing" @blur="doneUpdateQty(scope.row)" v-model="scope.row.quantity"></el-input>
                    <span v-show="!scope.row.isEditing" @click="updateQty(scope.row)"> {{ scope.row.quantity==null ? '-' : scope.row.quantity  }}</span>
                </template>
            </el-table-column>

            <el-table-column
             prop="uom"
             label="U.O.M"
             width="250"
            >
                <template slot-scope="scope">
                    <el-select
                        v-show="scope.row.isEditingUOM"
                        v-model="scope.row.uom"
                        placeholder="Select UOM"
                        @change="scope.row.isEditingUOM=false"
                    >
                        <el-option
                        v-for="item in scope.row.available_uoms" :key="item.uom"
                        :label="item.uom"
                        :value="item.uom"
                        >

                        </el-option>
                    </el-select>
                    <span v-show="!scope.row.isEditingUOM" @click="scope.row.isEditingUOM=true">
                        <span v-if="scope.row.uom == null">
                            -
                        </span>
                        <span v-else>
                            {{scope.row.uom}}
                        </span>
                    </span>
                </template>
            </el-table-column>
            <el-table-column
             prop="estimated_price"
             label="Est. Price"
             width="100"
            >
                <template slot-scope="scope">
                    <el-input :id="'priceInput'+scope.row.rowId" v-show="scope.row.isEditingPrice" @blur="doneUpdatePrice(scope.row)" v-model="scope.row.estimated_price"></el-input>
                    <span v-show="!scope.row.isEditingPrice" @click="updatePrice(scope.row)"> {{ scope.row.estimated_price  }}</span>
                </template>
            </el-table-column>
        </el-table>
        <div class="mt-10">
            <el-button size="mini" @click="addRow">Add Items</el-button>
            <el-button size="mini" type="primary" @click="savePO">Save Purchase Order</el-button>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
export default {
    props: ['items'],
    data () {
        return {
            gridPO: [{
                rowId: 1,
                item: null,
                quantity: null,
                uom: null,
                estimated_price: 0,
                isEditing: false, // quantity
                isEditingItem: false,
                isEditingUOM: false,
                isEditingPrice: false,
                available_uoms: []
            },
            // {   rowId: 2,
            //     item: 'Nagoya',
            //     quantity: null,
            //     uom: null,
            //     isEditing: false
            // },
            ]
        }
    },

    methods: {
        updateQty (row) {
           // document.getElementById('qtyInput'+row.rowId).focus()
            setTimeout(()=>{
                document.getElementById('qtyInput'+row.rowId).focus()
            }, 500)
            row.isEditing = true
        },
        doneUpdateQty (row) {
            row.isEditing = false
        },
        updatePrice (row) {
           // document.getElementById('qtyInput'+row.rowId).focus()
            setTimeout(()=>{
                document.getElementById('priceInput'+row.rowId).focus()
            }, 500)
            row.isEditingPrice = true
        },
        doneUpdatePrice (row) {
            row.isEditingPrice = false
        },

        updateItem (row) {
            row.isEditingItem = true
        },

        doneUpdateItem (row) {
            row.isEditingItem = false
            row.uom = null
            row.available_uoms = _.find(this.items, function (o) {return o.id == row.item}).item_attributes.uoms
        },

        getItemName: function (value) {
            return _.find(this.items, function (o) {return o.id == value}).name
        },

        addRow: function () {
            this.gridPO.push({
                rowId: this.gridPO.length + 1,
                item: null,
                quantity: null,
                uom: null,
                estimated_price: 0,
                isEditing: false, // quantity
                isEditingItem: false,
                isEditingUOM: false,
                isEditingPrice: false,
                available_uoms: []
            })
        },

        savePO: function () {
            window.axios.post('/save-po', {poDetails: this.gridPO}).then(resx=>{
                console.log(resx.data)
            })
        }
    }
}
</script>