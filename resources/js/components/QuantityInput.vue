<template>
  <input class="form-input w-full" :class="{'form-input-error': classError}"
         :id="id" :name="name" :type="type"
         :value="tempValue"
         @input="updateValue($event)"
         :placeholder="placeholder"
         :required="required">
</template>

<script>
  export default {
    name: "quality-input",
    props: {
      value: {
        // required: true,
        default: '',
      },
      name: {
        type: String,
        required: true,
      },
      type: {
        type: String,
        default: 'text',
      },
      required: {
        type: Boolean,
        default: true,
      },
      placeholder: {
        type: String,
      },
      disabled: {
        type: Boolean,
        default: false,
      },
      id: {
        type: String,
      },
      // classes: {
      //   default: {}
      // },
      classError: {
        default: false
      }
    },
    data() {
      return {
        tempValue: '',
      }
    },
    mounted() {
      if (this.value) {
        this.tempValue = this.filterValue(this.value);
      }
    },
    watch: {
      value: function (newValue) {
        // console.log(newValue);
        // console.log(this.$refs.mobileAskBidPanel.style.top);
        // this.tempValue = this.filterValue(newValue);
        // event.target.value = this.tempValue; // update form input
        if (!newValue) {
          this.tempValue = '';
          // event.target.value = this.tempValue;
        }
      },
    },
    methods: {
      updateValue(event) {
        this.tempValue = this.filterValue(event.target.value.trim());
        event.target.value = this.tempValue; // update form input
        this.$emit('input', parseInt(this.tempValue), event);
      },
      filterValue(input) {
        return input.replace(/[^\d]/g,'');
      }
    }
  }
</script>

