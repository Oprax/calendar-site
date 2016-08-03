import Vue from 'vue'
import VueResource from 'vue-resource'
import Filter from './components/filter.vue'

Vue.use(VueResource)

/* eslint-disable no-new */
new Vue({
  el: 'body',
  components: { Filter }
})
