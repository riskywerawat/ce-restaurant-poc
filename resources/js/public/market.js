require('../bootstrap');
window.Vue = require('vue');
import Errors from '../Errors';
import Axios from 'axios';
import Vuelidate from 'vuelidate';
import { required, minLength, minValue, maxValue } from 'vuelidate/lib/validators';
import VCalendar from 'v-calendar/lib/v-calendar.umd';
import VueApexCharts from 'vue-apexcharts';
// import {Money} from 'v-money';

Vue.component('apexchart', VueApexCharts);
Vue.component('card-modal', require('../components/CardModal.vue').default);
Vue.component('price-input', require('../components/PriceInput.vue').default);
Vue.component('quantity-input', require('../components/QuantityInput.vue').default);
// Vue.component('money', Money);
// Vue.component('vue-datepicker', require('../components/vue-tailwind-picker.vue').default);
Vue.use(VCalendar, {
  componentPrefix: 'vc',  // Use <vc-calendar /> instead of <v-calendar />
 //...,                // ...other defaults
});

Vue.use(Vuelidate);

const pinValidation = (value) => /^\d{6}$/gm.test(value);

const app = new Vue({
  el: '#app',
  data: {
    minDate: null,
    maxDate: null,
    askConfirmModalShowing: false, // show confirmation modal
    ask_delivery_date: [],
    ask_quantity: null,
    ask_price: null,
    askSubmitting: false, // show loading when true
    askSuccess: false, // show success screen
    askErrors: null,
    fee: fee, // ask or bid depend on user's type
    maxBidPrice: maxBidPrice, // max bid price
    maxAskPrice: maxAskPrice, // max ask price
    bidConfirmModalShowing: false, // show confirmation modal
    bid_delivery_date: [],
    bid_quantity: null,
    bid_price: null,
    bidSubmitting: false, // show loading when true
    bidSuccess: false, // show success screen
    bidErrors: null,
    asks: asks,
    bids: bids,
    pin: null,
    myAsks: myAsks,
    myBids: myBids,
    baseUrl: baseUrl,
    deleteBidModalShowing: false,
    deleteAskModalShowing: false,
    bid_to_delete: null,
    ask_to_delete: null,
    // priceRule: {
    //   decimal: '.',
    //   thousands: ',',
    //   prefix: '',
    //   suffix: '',
    //   precision: 2,
    //   masked: false
    // },
    graphOptions: {
      chart: {
        id: 'vuechart-example',
        fontFamily: 'Lato, Prompt, Helvetica, Arial, sans-serif',
        background: 'transparent',
        type: 'candlestick',
        toolbar: {
          tools: {
            download: '<svg class="w-5 h-5 text-kimberly-secondary hover:text-kimberly-inactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" fill="currentColor" /></svg>',
            selection: false,
            zoom: false,
            zoomin: false,
            zoomout: false,
            pan: false,
            reset: false
          }
        }
      },
      // colors: ['rgba(30, 126, 12, 0.85)', 'rgba(163, 251, 188, 0.85)', 'rgba(255, 82, 82, 0.85)', 'rgba(255, 125, 82, 0.85)', 'rgba(104, 104, 207, 0.85)', 'rgba(104, 145, 207, 0.85)'],
      xaxis: {
        labels: {
          style: {
            colors: '#9C9ACB',
          }
        },
        axisBorder: {
          color: '#8585AD'
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: '#9C9ACB',
          },
          formatter: function(value) {
            return Math.round(value).toLocaleString();
          }
        },
        title: {
          text: lang == 'th' ? "ราคา (บาท/MMBTU)" : "Price (THB/MMBTU)",
          style: {
            color: '#9C9ACB',
            fontSize: '11px',
            fontWeight: 700,
            cssClass: 'tracking-wider',
          }
        }
      },
      grid: {
        borderColor: '#43437A',
      },
      legend: {
        labels: {
          colors: "#E1E1EF",
        }
      },
      plotOptions: {
        candlestick: {
          colors: {
            upward: '#68BE58',
            downward: '#68BE58'
          }
        }
      },
      tooltip: {
        theme: "dark",
        custom: function({series, seriesIndex, dataPointIndex, w}) {
          // var o = w.globals.seriesCandleO[seriesIndex][dataPointIndex];
          // var h = w.globals.seriesCandleH[seriesIndex][dataPointIndex];
          // var l = w.globals.seriesCandleL[seriesIndex][dataPointIndex];
          // var c = w.globals.seriesCandleC[seriesIndex][dataPointIndex];
          // console.log(`seriesIndex: ${seriesIndex}, dataPointIndex: ${dataPointIndex}`);
          let o = graphDataReal[dataPointIndex]['y'][0];
          let h = graphDataReal[dataPointIndex]['y'][1];
          let l = graphDataReal[dataPointIndex]['y'][2];
          let c = graphDataReal[dataPointIndex]['y'][3];
          const suffix = lang == 'th' ? "  <span class='text-gray-400 text-sm'>บาท/MMBTU</span>" : " <span class='text-gray-400 text-sm'>THB/MMBTU</span>";
          if (o) {
            o = '<span class="font-bold">' + o.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</span> ' + suffix;
          } else {
            o = '-'
          }
          if (h) {
            h = '<span class="font-bold">' + h.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</span> ' + suffix;
          } else {
            h = '-'
          }
          if (l) {
            l = '<span class="font-bold">' + l.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</span> ' + suffix;
          } else {
            l = '-'
          }
          if (c) {
            c = '<span class="font-bold">' + c.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</span> ' + suffix;
          } else {
            c = '-'
          }
          return '<div class="p-2">' +
              // `<div>${lang == 'th' ? 'ซื้อต่ำสุด' : 'Lowest Bid'}: `+o+'</div>' +
              // `<div>${lang == 'th' ? 'จับคู่สำเร็จต่ำสุด' : 'Lowest Matched'}: `+h+'</div>' +
              // `<div>${lang == 'th' ? 'จับคู่สำเร็จสูงสุด' : 'Highest Matched'}: `+l+'</div>' +
              // `<div>${lang == 'th' ? 'ขายสูงสุด' : 'Highest Offer'}: `+c+'</div>' +
              `<div>${lang == 'th' ? 'จับคู่สำเร็จต่ำสุด' : 'Lowest Matched'}: `+o+'</div>' +
              `<div>${lang == 'th' ? 'ขายสูงสุด' : 'Highest Offer'}: `+h+'</div>' +
              `<div>${lang == 'th' ? 'ซื้อต่ำสุด' : 'Lowest Bid'}: `+l+'</div>' +
              `<div>${lang == 'th' ? 'จับคู่สำเร็จสูงสุด' : 'Highest Matched'}: `+c+'</div>' +
              '</div>';
        }
      },
      theme: {
        mode: 'dark',
      },
      stroke: {
        width: 2
      }
    },
    graphData: graphData,
    graphDateRange: {start: null, end: null},
    mobileActiveTab: 'asks-bids', // 'graph', 'asks-bids', 'my-offers'
    asksBidsActiveTab: 'bids', // 'asks', 'bids'
    mobileAskBidPanelExpanded: false,
  },
  validations() {
    let rules = {
      ask_delivery_date: { required, minLength: minLength(1) },
      ask_quantity: { required, minValue: minValue(1000) },
      ask_price: { required, minValue: minValue(1) },
      askGroup: ['ask_delivery_date', 'ask_quantity', 'ask_price'],
      bid_delivery_date: { required, minLength: minLength(1) },
      bid_quantity: { required, minValue: minValue(1000) },
      bid_price: { required, minValue: minValue(1) },
      bidGroup: ['bid_delivery_date', 'bid_quantity', 'bid_price'],
      pin: { required, pinValidation },
    }
    if (this.maxBidPrice) {
      rules.bid_price = { required, minValue: minValue(1000), maxValue: maxValue(this.maxBidPrice) }
    }
    if (this.maxAskPrice) {
      rules.ask_price = { required, minValue: minValue(1000), maxValue: maxValue(this.maxAskPrice) }
    }
    return rules;
  },
  created() {
    this.bidErrors = new Errors();
    this.askErrors = new Errors();
    this.minDate = new Date(minDateRaw);
    this.maxDate = new Date(maxDateRaw);
    this.graphDateRange = {start: new Date(minDateRaw), end: new Date(maxDateRaw)};
  },
  watch: {
    mobileAskBidPanelExpanded: function (val) {
      // console.log(this.$refs.mobileAskBidPanel.style.top);
      if (val == true) {
        this.$refs.mobileAskBidPanel.style.top = "-"+this.$refs.mobileAskBidPanel.offsetHeight+"px";
      } else {
        this.$refs.mobileAskBidPanel.style.top = "-4rem";
      }
    },
  },
  computed: {
    // bidQuantityComputed: {
    //   get:function() {
    //     return this.bid_quantity
    //   },
    //   set:function(newValue) {
    //     this.bid_quantity = newValue.replace(/[^\d.]/g,'');
    //   }
    // },
    bidDeliveryDateDisplay() {
      // return this.bid_delivery_date.map(date => date.toLocaleDateString('en-GB')).join(', ');
      return this.formattedDateMultiple(this.bid_delivery_date);
    },
    bidPriceDisplay() {
      if (!this.bid_price) {
        return null;
      }
      return this.moneyFormat(this.bid_price);
    },
    bidQuantityDisplay() {
      if (!this.bid_quantity) {
        return null;
      }
      return this.quantityFormat(this.bid_quantity);
    },
    bidTotalPerDay() {
      return this.bid_quantity * this.bid_price;
    },
    bidTotalPerDayWithFeeDisplay() {
      return this.moneyFormat((100 + this.fee)/100 * this.bidTotalPerDay);
    },
    bidTotal() {
      return this.bidTotalPerDay * this.bid_delivery_date.length;
    },
    bidTotalWithFee() {
      return this.bidTotal + this.bidFee;
    },
    bidFee() {
      return this.bidTotal * (this.fee/100);
    },
    bidFeeDisplay() {
      return this.moneyFormat(this.bidFee);
    },
    bidTotalDisplay() {
      return this.moneyFormat(this.bidTotal);
    },
    bidTotalWithFeeDisplay() {
      return this.moneyFormat(this.bidTotalWithFee);
    },

    askDeliveryDateDisplay() {
      // return this.ask_delivery_date.map(date => date.toLocaleDateString('en-GB')).join(', ');
      return this.formattedDateMultiple(this.ask_delivery_date);
    },
    askPriceDisplay() {
      if (!this.ask_price) {
        return null;
      }
      return this.moneyFormat(this.ask_price);
    },
    askQuantityDisplay() {
      if (!this.ask_quantity) {
        return null;
      }
      return this.quantityFormat(this.ask_quantity);
    },
    askTotalPerDay() {
      return this.ask_quantity * this.ask_price;
    },
    askTotalPerDayWithFeeDisplay() {
      // console.log((100 - this.fee/100));
      // console.log(this.askTotalPerDay);
      return this.moneyFormat((100 - this.fee)/100 * this.askTotalPerDay);
    },
    askTotal() {
      return this.askTotalPerDay * this.ask_delivery_date.length;
    },
    askTotalWithFee() {
      return this.askTotal - this.askFee;
    },
    askFee() {
      return this.askTotal * (this.fee/100);
    },
    askFeeDisplay() {
      return this.moneyFormat(this.askFee);
    },
    askTotalDisplay() {
      return this.moneyFormat(this.askTotal);
    },
    askTotalWithFeeDisplay() {
      return this.moneyFormat(this.askTotalWithFee);
    }
  },
  mounted() {
    // console.log('mounted');
    window.Echo.private('market')
        .listen('MarketDataUpdated', (e) => {
          // console.log(e);
          this.updateData();
        });
  },
  methods: {
    formattedDateRange(dateRange) {
      return this.dateFormat(dateRange.start) + '-' + this.dateFormat(dateRange.end);
    },
    formattedDateMultiple(dateArray) {
      let results = [];
      for (let i = 0; i < dateArray.length; i++) {
        let start = dateArray[i];
        let end = start;
        while (dateArray.length > i+1 && this.isTomorrow(dateArray[i], dateArray[i+1])) {
          end = dateArray[i+1];
          i++;
        }
        results.push(start == end ? this.dateFormat(start) : this.dateFormat(start) + '-' + this.dateFormat(end));
      }
      return results.join(', ');
    },
    isTomorrow(date1, date2) {
      const diffTime = Math.abs(date2 - date1);
      // console.log(diffTime);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      return diffDays == 1;
    },
    dateFormat(inputDate) // for display in UI (text)
    {
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
    // dateFormatter(inputDate) { // for display in input
    //   // return input.toLocaleDateString('en-GB');
    //   let month = '' + (inputDate.getMonth() + 1),
    //       day = '' + inputDate.getDate(),
    //       year = ('' + inputDate.getFullYear()).substring(0,2);
    //
    //   if (month.length < 2)
    //     month = '0' + month;
    //   if (day.length < 2)
    //     day = '0' + day;
    //
    //   return [day, month, year].join('/');
    // },
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
    quantityFormat(input) {
      return input.toLocaleString('en-US');
    },
    moneyFormat(input) {
      return input.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    },
    openConfirmBidModal() {
      this.$v.bidGroup.$touch();
      if (this.$v.bidGroup.$error) {
        return;
      }

      this.bidConfirmModalShowing = true;
      this.bidSuccess = false;
      this.$nextTick(() => {
        this.$refs.bidPin.focus();
      });
    },
    closeBidModal() {
      if (this.bidSubmitting) {
        return ;
      }
      this.bidConfirmModalShowing = false;
      this.bidSuccess = false;
    },
    confirmSubmitBid() {
    
      // validate
      this.$v.pin.$touch();
      if (this.$v.pin.$error) {
        return;
      }

      this.bidSubmitting = true;

      // setTimeout(() => {
      //   this.bidSuccess = true;
      //   this.bidSubmitting = false;
      // }, 2000)
      const payload = {
        pin: this.pin,
        quantity: this.bid_quantity,
        price: this.bid_price,
        delivery_date: this.bid_delivery_date.map(d => this.dateFormatValue(d)),
      };
      console.log(JSON.stringify(payload));
      console.log(this.baseUrl+"/bids");
      window.axios.post(this.baseUrl+'/bids', payload) //{"pin":"123456","quantity":2000,"price":2100,"delivery_date":["2021-05-26"]}
        .then(response => {
         console.log("response:: data",response);
          this.bidSuccess = true;
          this.resetBidForm();
          this.updateData();
        })
        .catch((error) => {
          // pin error
          console.error("error ->" ,error);
          this.bidErrors.record(error.response.data.errors);
        })
        .finally(() => {
          this.bidSubmitting = false;
          this.pin = null;
          this.$v.pin.$reset();
        });
    },
    resetBidForm() {
      this.bid_delivery_date = [];
      this.bid_quantity = null;
      this.bid_price = null;
      this.pin = null;
      this.$v.bidGroup.$reset();
    },

    openConfirmAskModal() {
      this.$v.askGroup.$touch();
      if (this.$v.askGroup.$error) {
        return;
      }

      this.askConfirmModalShowing = true;
      this.askSuccess = false;
      this.$nextTick(() => {
        this.$refs.askPin.focus();
      });
    },
    closeAskModal() {
      if (this.askSubmitting) {
        return ;
      }
      this.askConfirmModalShowing = false;
      this.askSuccess = false;
    },
    confirmSubmitAsk() {
      // alert('Submit Ask');
      // validate
      this.$v.pin.$touch();
      if (this.$v.pin.$error) {
        return;
      }

      this.askSubmitting = true;

      // setTimeout(() => {
      //   this.askSuccess = true;
      //   this.askSubmitting = false;
      // }, 2000)
      const payload = {
        pin: this.pin,
        quantity: this.ask_quantity,
        price: this.ask_price,
        delivery_date: this.ask_delivery_date.map(d => this.dateFormatValue(d)),
      };
      window.axios.post(this.baseUrl+'/asks', payload)
          .then(response => {
            // console.log('yo');
            this.askSuccess = true;
            this.resetAskForm();
            this.updateData();
          })
          .catch((error) => {
            // pin error
            console.error(error);
            this.askErrors.record(error.response.data.errors);
          })
          .finally(() => {
            this.askSubmitting = false;
            this.pin = null;
            this.$v.pin.$reset();
          });
    },
    resetAskForm() {
      this.ask_delivery_date = [];
      this.ask_quantity = null;
      this.ask_price = null;
      this.pin = null;
      this.$v.askGroup.$reset();
    },
    updateData() {
      this.updateGraph(); // also update graph when update data
      window.axios.get(this.baseUrl+'/market-data')
        .then(response => {
          this.asks = response.data.asks;
          this.bids = response.data.bids;
          this.myAsks = response.data.myAsks;
          this.myBids = response.data.myBids;
        })
        .catch(error => {

        });
    },
    confirmDeleteBid(bid) {
      this.bid_to_delete = bid;
      this.deleteBidModalShowing = true;
    },
    deleteBid() {
      if (!this.bid_to_delete) {
        return;
      }
      window.axios.delete(`${this.baseUrl}/bids/${this.bid_to_delete.id}`)
        .then(response => {
          if (response.data.success) {
            this.updateData();
            this.deleteBidModalShowing = false;
            this.bid_to_delete = null;
            document.dispatchEvent(new CustomEvent('toast', {detail: {type: 'success', text: response.data.message}}));
          }
        })
        .catch(error => {
         console.log(error);
        });
    },
    confirmDeleteAsk(ask) {
      this.ask_to_delete = ask;
      this.deleteAskModalShowing = true;
    },
    deleteAsk() {
      if (!this.ask_to_delete) {
        return;
      }
      window.axios.delete(`${this.baseUrl}/asks/${this.ask_to_delete.id}`)
          .then(response => {
            if (response.data.success) {
              this.updateData();
              this.deleteAskModalShowing = false;
              this.ask_to_delete = null;
              document.dispatchEvent(new CustomEvent('toast', {detail: {type: 'success', text: response.data.message}}));
            }
          })
          .catch(error => {
            console.log(error);
          });
    },
    historyLink(id) {
      return `${this.baseUrl}/history?mode=ongoing&id=${id}`;
    },
    updateGraph() {
      // alert('update graph');
      const payload = {
        start: this.dateFormatValue(this.graphDateRange.start, ''),
        end: this.dateFormatValue(this.graphDateRange.end, ''),
      }
      window.axios.post(`${this.baseUrl}/graph-data`, payload)
          .then(response => {
            if (response.data.success) {
              this.graphData = response.data.data;
              const options = {...this.graphOptions};
              options.xaxis.categories = response.data.label;
              this.graphOptions = options;
            }
          })
          .catch();
    },
    // filterBidQuantityInput(e) {
    //   // this.bid_quantity = e.target.value.replace(/[^0-9.]+/g, '');
    //   // console.log(e.target.value.replace(/[^0-9.]+/g, ''));
    //   // console.log(e.target.value);
    //   const newValue = e.target.value.replace(/[^\d.]/g,'');
    //   // console.log(newValue);
    //   // console.log("---");
    //   this.bid_quantity = parseInt(newValue) || 0;
    //   e.target.value = this.bid_quantity;
    // },
    // filterBidPriceInput(e) {
    //   const newValue = e.target.value.replace(/[^\d.]/g,'');
    //   this.bid_price = parseFloat(newValue) || 0;
    //   e.target.value = this.bid_price;
    // }
  },
});
