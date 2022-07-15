<template>
   <div class="space-y-5">
      <el-table
        :data="purchaseOrder.purchase_order_details"
      >
          <el-table-column
            label="ID"
            width="70"
          >
              <template slot-scope="scope">
                {{scope.row.id}}
              </template>
          </el-table-column>
          <el-table-column
            label="Item"
          >
              <template slot-scope="scope">
                <span class="text-md font-bold">{{scope.row.item.name}}</span>
                <div>
                  <el-tag type="info" size="mini">{{scope.row.item.subcategories.categories.name}}</el-tag> <span class="text-xs italic">({{scope.row.item.subcategories.name}})</span>
                </div>
              </template>
          </el-table-column>
          <el-table-column
            label="Est. Price"
            width="90"
          >
              <template slot-scope="scope">
                {{scope.row.tentative_total_price}}
              </template>
          </el-table-column>
          <el-table-column
            label="Quantity"
            width="120"
          >
              <template slot-scope="scope">
                {{scope.row.quantity}} {{scope.row.uom}}
              </template>
          </el-table-column>
          <el-table-column
            label="Supplied"
            width="90"
          >
             0
          </el-table-column>
      </el-table>

      <el-button class="mt-10" @click="generateRpt">Print</el-button>
   </div>
</template>

<script>
export default {
 props: ['purchaseOrder'],

 methods: {
  generateRpt() {

            var iframe = '<html><title>Observation Report</title><head><style>body, html {width: 100%; height: 100%; margin: 0; padding: 0}</style></head><body><iframe src="http://localhost:8000/print" style="height:calc(100% - 4px);width:calc(100% - 4px)"></iframe></html></body>';

               // var win = window.open("","","width=720,height=480,toolbar=no,menubar=no,resizable=yes");
               // win.document.write(iframe);

                window.open("http://localhost:8000/print","","width=720,height=480,toolbar=no,menubar=no,resizable=yes");
      }
 }

}
</script>