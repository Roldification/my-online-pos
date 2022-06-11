
const setItemsPageInfo  = (state, payload) => {
  state.itemsPageInfo = payload
}

const setLoadingStatus = (state, payload) => {
  state.isPageLoading = payload
}


export default {
  setItemsPageInfo,
  setLoadingStatus
}