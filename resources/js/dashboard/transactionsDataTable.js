// import makeId from '../mixins/makeId';
import VCalendar from 'v-calendar/lib/v-calendar.umd';

require('../bootstrap');
window.Vue = require('vue');

// Vue.component('toggle', require('./components/Toggle.vue').default);
Vue.use(VCalendar, {
  componentPrefix: 'vc',  // Use <vc-calendar /> instead of <v-calendar />
  //...,                // ...other defaults
});
const app = new Vue({
  el: '#app',
  // mixins: [makeId],
  data: {
    search: '',
    price_min: null,
    price_max: null,
    quantity_min: null,
    quantity_max: null,
    delivery_start: null,
    delivery_end: null,
    order_by: 'created_at',
    order: 'desc',
  },
  computed: {},
  mounted() {
    this.buildFilterParamsFromUrl();
  },
  methods: {
    dateFormat(inputDate, separator = '/') // for display in UI (text)
    {
      if (!inputDate) {
        return;
      }

      // return date.toLocaleDateString('en-GB');
      let month = '' + (inputDate.getMonth() + 1),
          day = '' + inputDate.getDate(),
          year = ('' + inputDate.getFullYear()).substring(0,2);

      if (month.length < 2)
        month = '0' + month;
      if (day.length < 2)
        day = '0' + day;

      return [day, month, year].join(separator);
    },
    dateFormatValue(inputDate, separator = '-') // for api
    {
      if (!inputDate) {
        return;
      }

      // return date.toLocaleDateString('en-GB');
      let month = '' + (inputDate.getMonth() + 1),
          day = '' + inputDate.getDate(),
          year = '' + inputDate.getFullYear();

      if (month.length < 2)
        month = '0' + month;
      if (day.length < 2)
        day = '0' + day;

      return [year, month, day].join(separator);
    },
    buildFilterParamsFromUrl() {
      let items = window.location.search.substr(1).split("&");
      for (let index = 0; index < items.length; index++) {
        const tmp = items[index].split("=");
        const key = tmp[0];
        const val = tmp[1];
        if (key == 'search') {
          this.search = val;
        }
        if (key == 'price_min') {
          this.price_min = val;
        }
        if (key == 'price_max') {
          this.price_max = val;
        }
        if (key == 'quantity_min') {
          this.quantity_min = val;
        }
        if (key == 'quantity_max') {
          this.quantity_max = val;
        }
        if (key == 'delivery_start') {
          this.delivery_start = new Date(val);
        }
        if (key == 'delivery_end') {
          this.delivery_end = new Date(val);
        }
        if (key == 'order_by') {
          this.order_by = val;
        }
        if (key == 'order') {
          this.order = val;
        }
        if (key == 'page_y') {
          document.getElementById("app").scrollTop = val;
        }
      }
    },
    orderMarkClass(key, order) {
      if (this.order_by === key && this.order === order) {
        return 'text-gray-800';
      }
      return 'text-gray-400';
    },
    changeOrder(key) {
      if (this.order_by == key) { // click same key, just reverse order
        this.order = this.order === 'asc' ? 'desc' : 'asc';
        this.reloadSearch();
        return;
      }
      this.order_by = key;
      this.order = 'desc';
      this.reloadSearch();
    },
    getBaseUrl() {
      return window.location.origin+window.location.pathname;
    },
    reloadSearch(ajax = false) {
      const page_y = document.getElementById('app').scrollTop;
      let getParams = {
        order_by: this.order_by,
        order: this.order,
        page_y: page_y
      };
      if (this.search) {
        getParams.search = this.search;
      }
      if (this.price_min) {
        getParams.price_min = this.price_min;
      }
      if (this.price_max) {
        getParams.price_max = this.price_max;
      }
      if (this.quantity_min) {
        getParams.quantity_min = this.quantity_min;
      }
      if (this.quantity_max) {
        getParams.quantity_max = this.quantity_max;
      }
      if (this.delivery_start) {
        getParams.delivery_start = this.dateFormatValue(this.delivery_start, '-');
      }
      if (this.delivery_end) {
        getParams.delivery_end = this.dateFormatValue(this.delivery_end, '-');
      }

      window.location.href = this.getBaseUrl() + '?' + this.encodeQueryData(getParams);
    },
    encodeQueryData(data) {
      const ret = [];
      for (let d in data) {
        ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
      }
      return ret.join('&');
    }
  },
});


