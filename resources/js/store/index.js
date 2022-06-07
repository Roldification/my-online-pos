import Vue from 'vue'
import Vuex from 'vuex'
import items from './items/items.js'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    items
  },
  strict: false
})