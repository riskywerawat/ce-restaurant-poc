window.Vue = require('vue');

// const app = Vue.createApp({
//   data() {
//     return {
//       deleteModalShowing: 0
//     }
//   },
//   computed: {
//   },
//   mounted() {
//   },
//   methods: {
//   },
// });
//
// app.component('card-modal', require('./components/CardModal.vue').default);
// app.mount('#app');

Vue.component('card-modal', require('./components/CardModal.vue').default);

const app = new Vue({
  el: '#app',
  data: {
    deleteModalShowing: false,
  },
  computed: {
  },
  mounted() {
  },
  methods: {
  },
});

