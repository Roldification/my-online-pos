<template>
  <div>
    hellowx 2 {{gridItems.length}}

    <el-table
      :size="'small'"
      :data="gridItems.data"
      v-loading="isPageLoading"
    >
      <el-table-column
      prop="name"
      label="Item Name"
      >

      </el-table-column>

      <el-table-column label="Operations">
          <template slot-scope="scope">
              <el-button
                size="mini"
                @click="handleView(scope.row.id)">View</el-button>
          </template>
      </el-table-column>
    </el-table>

    <div class="grid justify-items-end mt-2">
      <el-pagination
        :current-page="gridItems.current_page"
        background
        :page-size="gridItems.per_page"
        @current-change="pageChange"
        layout="prev, pager, next"
        :total="gridItems.total">
      </el-pagination>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      pageInfo: {
        current_page: 1
      }

    }
  },
  computed: {
    gridItems() {
      return this.$store.state.items.itemsPageInfo
    },
    isPageLoading() {
      return this.$store.state.items.isPageLoading
    }
  },

  created () {
    this.loadItems()
  },

  methods: {
    loadItems () {
      // window.axios.get('get-recent-items?page='+this.pageInfo.current_page).then(res=>{
      //   console.log(res.data)
      //   this.pageInfo = res.data
      // }).catch(err=>console.log(err.message))
      this.$store.dispatch('items/fetchItems', 1)
    },

    pageChange (page) {
      console.log(page)
      this.$store.dispatch('items/fetchItems', page)
    },

    handleView (row) {
      window.location=`/view-item?id=${row}`
      console.log(row)
    }
  }
}
</script>
