require('../bootstrap');
window.Vue = require('vue');
import Errors from '../Errors';
import VCalendar from 'v-calendar/lib/v-calendar.umd';

Vue.component('card-modal', require('../components/CardModal.vue').default);
Vue.component('history-item', require('../components/history-item.vue').default);
Vue.component('history-item-mobile', require('../components/history-item-mobile.vue').default);
// Vue.component('vue-datepicker', require('../components/vue-tailwind-picker.vue').default);
Vue.use(VCalendar, {
  componentPrefix: 'vc',  // Use <vc-calendar /> instead of <v-calendar />
 //...,                // ...other defaults
});

const app = new Vue({
  el: '#app',
  data: {
    requests: requests,
    mode: mode,
    type: type,
    baseUrl: baseUrl,
    req_to_delete: null,
    deleteOfferModalShowing: false,
    // historyDateRange: {start: null, end: null},
    requestsDateRange: {start: null, end: null},
    order: 'asc',
    orderBy: 'delivery_date_timestamp'
  },
  created() {
    this.requestsDateRange = {start: new Date(minDateRaw), end: new Date(maxDateRaw)};
  },
  computed: {
    allCount() {
      return this.requests.length;
    },
    ongoingCount() {
      return this.requests.filter(req => req.status == 1).length;
    },
    matchedCount() {
      return this.requests.filter(req => req.status == 2).length;
    },
    cancelledCount() {
      return this.requests.filter(req => req.status == 10).length;
    },
    expiredCount() {
      return this.requests.filter(req => req.status == 11).length;
    },
    filteredRequests() {
      switch (this.mode) {
        case 'all':
          return this.requests;
        case 'ongoing':
          return this.requests.filter(req => req.status == 1);
        case 'matched':
          return this.requests.filter(req => req.status == 2);
        case 'cancelled':
          return this.requests.filter(req => req.status == 10);
        case 'expired':
          return this.requests.filter(req => req.status == 11);
      }
    },
    filteredRequestsSorted() {
      // console.log(this.orderBy);
      return this.filteredRequests.sort((a, b) => {
        if (this.order == 'asc') {
          return a[this.orderBy] - b[this.orderBy];
        } else {
          return b[this.orderBy] - a[this.orderBy];
        }
      });
    },
  },
  mounted() {
    if (showId) {
      const refName = `history${showId}`;
      // console.log(refName);
      this.$refs[refName][0].manualOpen();
    }
  },
  methods: {
    formattedDateRange(dateRange) {
      // return 'yo';
      return this.dateFormat(dateRange.start) + '-' + this.dateFormat(dateRange.end);
    },
    dateFormat(inputDate) // for display in UI (text)
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

      return [day, month, year].join('/');
    },
    dateFormatValue(inputDate, separator = '-') { // for API payload
      let month = '' + (inputDate.getMonth() + 1),
          day = '' + inputDate.getDate(),
          year = inputDate.getFullYear();

      if (month.length < 2)
        month = '0' + month;
      if (day.length < 2)
        day = '0' + day;

      return [year, month, day].join(separator);
    },
    changeMode(mode) {
      this.mode = mode;
    },
    updateHistory() {
      window.axios.get(`${this.baseUrl}/history?start=${this.dateFormatValue(this.requestsDateRange.start)}&end=${this.dateFormatValue(this.requestsDateRange.end)}`)
        .then(response => {
          this.requests = response.data.requests;
        })
        .catch();
    },
    confirmDeleteOffer(req) {
      this.req_to_delete = req;
      this.deleteOfferModalShowing = true;
    },
    deleteOffer() {
      if (!this.req_to_delete) {
        return;
      }
      window.axios.delete(`${this.baseUrl}/${this.type}/${this.req_to_delete.id}`)
          .then(response => {
            if (response.data.success) {
              this.updateHistory();
              this.deleteOfferModalShowing = false;
              this.req_to_delete = null;
              document.dispatchEvent(new CustomEvent('toast', {detail: {type: 'success', text: response.data.message}}));
            }
          })
          .catch(error => {
            console.log('error');
          });
    },
    changeOrder(key) {

      if (this.orderBy == key) { // click same key, just reverse order
        this.order = this.order === 'asc' ? 'desc' : 'asc';
        // this.reloadSearch();
        return;
      }
      this.orderBy = key;
      this.order = 'desc';
      // this.reloadSearch();
    },
  },
});
