<template>
  <on-click-outside :do="close">
    <div class="relative" :class="{ 'is-active': isOpen }">
      <button ref="button" @click="open" type="button" class="form-select text-left w-full">
        <span v-if="selectedOption">{{ selectedOption['name'] }}</span>
        <span v-else class="text-gray-400">{{ placeholder }}</span>
      </button>
      <div ref="dropdown" v-show="isOpen" class="absolute right-0 left-0 w-full bg-gray-700 p-2 rounded shadow z-50 my-1">
        <input class="block mb-2 w-full py-2 px-3 bg-gray-500 text-white rounded"
               v-model="search"
               ref="search"
               @keydown.esc="close"
               @keydown.up="highlightPrev"
               @keydown.down="highlightNext"
               @keydown.enter.prevent="selectHighlighted"
               @keydown.tab.prevent
        >
        <ul ref="options" v-show="filteredOptions.length > 0" class="p-0 relative overflow-y-auto scrolling-touch" style="max-height: 14rem;">
          <li class="py-2 px-3 text-white cursor-pointer rounded select-none hover:bg-gray-600"
              v-for="(option, i) in filteredOptions"
              :key="option['id']"
              @click="select(option)"
              :class="{ 'bg-blue-500 hover:bg-blue-500': i === highlightedIndex}"
          >{{ option['name'] }}</li>
        </ul>
        <div v-show="filteredOptions.length === 0" class="text-gray-300 py-2 px-3">No results found for "{{ search }}"</div>
      </div>
    </div>
  </on-click-outside>
</template>

<script>
  import OnClickOutside from "./OnClickOutside.vue";
  import { createPopper } from '@popperjs/core';

  export default {
    components: {
      OnClickOutside
    },
    // props: ["value", "options", "filterFunction"],
    props: {
      value: { required: true },
      options: { required: true, type: Array },
      placeholder: { default: 'Select value...' },
      filterFunction: {
        default: (search, options) => {
          // console.log(options);
          return options.filter(option => {
            // console.log(option);
            return option.name && option.name.toLowerCase().includes(search.toLowerCase())
          })
        },
        type: Function
      },
      allowDeselect: {default: false, type: Boolean}
    },
    data() {
      return {
        isOpen: false,
        search: "",
        highlightedIndex: 0
      }
    },
    beforeDestroy() {
      if (this.popper) {
        this.popper.destroy();
        this.popper = null;
      }
    },
    computed: {
      filteredOptions() {
        return this.filterFunction(this.search, this.options)
      },
      selectedOption() {
        return this.options.find(option => option.id == this.value);
      }
    },
    methods: {
      open() {
        if (this.isOpen) {
          return
        }
        this.isOpen = true

        if (this.value) {
          this.highlightedIndex = this.options.map(option => option.id).indexOf(this.value)
        }
        if (this.highlightedIndex < 0) {
          this.highlightedIndex = 0
        }

        this.$nextTick(() => {
          this.setupPopper()
          this.$refs.search.focus()
          this.scrollToHighlighted()
        })
      },
      setupPopper() {
        if (this.popper === undefined) {
          this.popper = createPopper(this.$refs.button, this.$refs.dropdown, {
            placement: "bottom"
          })
        } else {
          this.popper.update()
        }
      },
      close() {
        if (!this.isOpen) {
          return
        }
        this.isOpen = false
        this.$refs.button.focus()
      },
      select(option) {
        if (this.allowDeselect && option.id == this.value) {
          this.$emit("input", null)
        } else {
          this.$emit("input", option.id)
        }
        this.search = ""
        this.highlightedIndex = 0
        this.close()
      },
      selectHighlighted() {
        this.select(this.filteredOptions[this.highlightedIndex])
      },
      scrollToHighlighted() {
        if (this.filteredOptions.length == 0) {
          return
        }
        this.$refs.options.children[this.highlightedIndex].scrollIntoView({
          block: "nearest"
        })
      },
      highlight(index) {
        this.highlightedIndex = index

        if (this.highlightedIndex < 0) {
          this.highlightedIndex = this.filteredOptions.length - 1
        }

        if (this.highlightedIndex > this.filteredOptions.length - 1) {
          this.highlightedIndex = 0
        }

        this.scrollToHighlighted()
      },
      highlightPrev() {
        this.highlight(this.highlightedIndex - 1)
      },
      highlightNext() {
        this.highlight(this.highlightedIndex + 1)
      }
    }
  }
</script>
