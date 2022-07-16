<template>
    <div class="w-1/2">
        <el-form :model="warehouse" label-width="75px" :label-position="'left'" class="text-sm">
            <el-form-item label="Name">
                <el-input v-model="warehouse.name"></el-input>
            </el-form-item>

            <el-form-item>
                <el-button class="float-right" type="primary" @click="saveWarehouse">Create Warehouse</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            warehouse: {
                name: '',
                can_sell_from_here: true,
            }
        }
    },

    methods: {
        saveWarehouse () {
            window.axios.post('/store-warehouse', this.warehouse).then(res=>{

            }).catch(err=>{
                console.log(err)
            });
        }
    }
}
</script>