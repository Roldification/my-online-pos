import actions from './actions'
import mutations from './mutations'

const state = () => ({
  itemsPageInfo: {
    current_page: 1
  },
  isPageLoading: false,
})

export default {
  namespaced: true,
  state,
  actions,
  mutations
}