<template>
  <div class="mb-2">
    <div class="dark:bg-slate-800 px-4 pt-4 pb-2">
      <div class="flex items-center justify-between mb-2">
        <div><span class="uppercase px-2 py-1 rounded-full text-xs font-bold" :class="statusClass(req.status)">{{ statusText(req.status) }}</span></div>
        <div><span class="text-kimberly-secondary mr-1">{{ deliveryDateText }}:</span> {{ req.delivery_date }}</div>
      </div>
      <div class="flex items-center justify-between mb-2">
        <span class="text-kimberly-inactive">{{ qtyText }}</span>
        <div class="text-right" v-if="req.status == 1">
          <span class="font-bold">{{ quantityFormat(req.quantity_matched) }}</span><span class="text-kimberly-secondary">&nbsp;/ {{ quantityFormat(req.quantity) }}</span>
        </div>
        <div class="text-right" v-else>
          <span class="font-bold">{{ quantityFormat(req.quantity) }}</span>
        </div>
      </div>
      <div class="flex items-center justify-between mb-2">
        <div class="text-kimberly-inactive">{{ priceText }}</div>
        <div class="text-right font-bold">{{ moneyFormat(req.price) }}</div>
      </div>
      <div class="border-b border-midnight-light my-2"></div>
      <div class="flex items-center justify-between mb-2">
        <div class="text-kimberly-inactive">{{ totalText }}</div>
        <div class="text-kimberly-inactive">{{ moneyFormat(req.total_real) }}</div>
      </div>
      <div class="flex items-center justify-between mb-2">
        <div class="text-kimberly-inactive">{{ totalFeeText }}</div>
        <div class="font-bold">{{ moneyFormat(req.total_real_with_fee) }}</div>
      </div>

      <div class="text-center text-xs uppercase font-bold tracking-wide mb-2" v-show="req.status == 1">
        <a href="#"
           class="inline-flex items-center justify-center text-kimberly-secondary hover:text-kimberly-link"
           @click="deleteOffer"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          {{ deleteText }}</a>
      </div>

      <div class="mb-2">
        <a href="#" @click="toggle" v-show="req.transactions.length > 0"
           class="block flex items-center justify-center transform transition-all duration-150 px-3 py-1 focus:outline-none">
          <span class="mr-2">{{ showDetailText }}</span>
          <svg width="14" height="9" viewBox="0 0 14 9" fill="none" xmlns="http://www.w3.org/2000/svg" :class="{'rotate-90': !open}">
            <path d="M6.99995 9C6.74466 8.99871 6.49285 8.94061 6.26281 8.82991C6.03276 8.71921 5.83024 8.55869 5.66995 8.36L1.45995 3.26C1.21394 2.95297 1.05913 2.583 1.01316 2.19227C0.967195 1.80153 1.03191 1.40574 1.19995 1.05C1.33623 0.740826 1.55862 0.477413 1.84057 0.291222C2.12251 0.105032 2.45209 0.00393305 2.78995 0H11.2099C11.5478 0.00393305 11.8774 0.105032 12.1593 0.291222C12.4413 0.477413 12.6637 0.740826 12.7999 1.05C12.968 1.40574 13.0327 1.80153 12.9867 2.19227C12.9408 2.583 12.786 2.95297 12.5399 3.26L8.32995 8.36C8.16965 8.55869 7.96713 8.71921 7.73709 8.82991C7.50704 8.94061 7.25524 8.99871 6.99995 9Z" fill="#656692"/>
          </svg>
        </a>
      </div>
    </div>

    <div class="bg-midnight-darker max-h-0 origin-top overflow-hidden transition-all duration-150" :class="{'max-h-full duration-500': open}">
      <div class="text-sm text-kimberly-inactive px-4 mt-2 border-b border-midnight-border" v-for="transaction in req.transactions" :key="transaction.id">
        <div class="">{{ matchedText }} {{ transaction.created_at }}</div>
        <div class="flex items-center justify-between my-2 ml-3">
          <div>{{ qtyText }}</div>
          <div class="font-bold text-kimberly-primary">{{ quantityFormat(transaction.quantity) }}</div>
        </div>
        <div class="flex items-center justify-between my-2 ml-3">
          <div>{{ priceText }}</div>
          <div class="font-bold text-kimberly-primary">{{ moneyFormat(transaction.price) }}</div>
        </div>
        <div class="border-t border-midnight-border mb-2 ml-3"></div>
        <div class="flex items-center justify-between mb-2 ml-3">
          <div class="">{{ totalText }}</div>
          <div class="text-kimberly-primary">{{ moneyFormat(transaction.quantity * transaction.price) }}</div>
        </div>
        <div class="flex items-center justify-between mb-2 ml-3">
          <div class="">{{ totalFeeText }}</div>
          <div class="font-bold text-kimberly-primary">{{ moneyFormat(transaction.total) }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "history-item",
    props: {
      req: {
        required: true,
        type: Object
      },
      buyer: {
        default: true,
        type: Boolean
      }
    },
    data() {
      return {
        open: false,
        matchedText: lang == 'th' ? 'สำเร็จ' : 'Matched',
      }
    },
    computed: {
      deleteText() {
        if (lang == 'th') {
          return 'ลบ';
        } else {
          return 'Delete'
        }
      },
      showDetailText() {
        if (lang == 'th') {
          return 'รายละเอียด';
        } else {
          return 'Show Detail';
        }
      },
      deliveryDateText() {
        if (lang == 'th') {
          return 'วันส่งสินค้า';
        } else {
          return 'Delivery Date'
        }
      },
      qtyText() {
        if (lang == 'th') {
          return 'จำนวน (MMBTU)';
        } else {
          return 'Qty. (MMBTU)';
        }
      },
      priceText() {
        if (lang == 'th') {
          return 'ราคา (บาท/MMBTU)';
        } else {
          return 'Rate (THB/MMBTU)';
        }
      },
      totalText() {
        if (lang == 'th') {
          if (this.buyer) {
            return 'ประมาณที่ต้องจ่าย (บาท)'
          } else {
            return 'ประมาณเงินที่จะได้ (บาท)'
          }
        } else {
          if (this.buyer) {
            return 'Estimated Spend (THB)'
          } else {
            return 'Estimated Received (THB)'
          }
        }
      },
      totalFeeText() {
        let fee = this.req.fee;
        if (lang == 'th') {
          return `รวมทั้งสิ้น (รวมค่าธรรมเนียม ${fee}%)`
        } else {
          return `Grand Total (includes fee ${fee}%)`
        }
      }
    },
    methods: {
      toggle() {
        this.open = !this.open;
      },
      manualOpen() {
        this.open = true;
      },
      statusText(status) {
        if (lang == 'th') {
          switch (status) {
            case 1:
              return 'รอจับคู่';
            case 2:
              return 'สำเร็จ';
            case 10:
              return 'ยกเลิก';
            case 11:
              return 'หมดอายุ';
          }
        } else {
          switch (status) {
            case 1:
              return 'Ongoing';
            case 2:
              return 'Matched';
            case 10:
              return 'Cancelled';
            case 11:
              return 'Expired';
          }
        }
      },
      statusClass(status) {
        switch (status) {
          case 1:
            return 'text-yellow-800 bg-yellow-100';
          case 2:
            return 'text-green-800 bg-green-100';
          case 10:
            return 'text-red-800 bg-red-100';
          case 11:
            return 'text-gray-800 bg-gray-100';
        }
      },
      quantityFormat(input) {
        return input.toLocaleString('en-US');
      },
      moneyFormat(input) {
        return input.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
      },
      deleteOffer() {
        this.$emit('delete');
      }
    }
  }
</script>

<style scoped>

</style>
