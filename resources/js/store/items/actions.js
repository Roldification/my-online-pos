
const actionOne = (context, payload) => {
  return 0;
}

const fetchItems = (context, payload) => {
  context.commit('setLoadingStatus', true)
  window.axios.get('get-recent-items?page='+payload).then(resx=>{
    console.log('i went here')
    context.commit('setItemsPageInfo', resx.data)
    context.commit('setLoadingStatus', false)
  })
}


export default {
  actionOne,
  fetchItems
}