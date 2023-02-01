<template>

</template>

<script>
import dayjs from 'dayjs';
// import isToday from 'dayjs/plugin/isToday';
// import customParseFormat from 'dayjs/plugin/customParseFormat';
// import isBetween from 'dayjs/plugin/isBetween';
// import localizedFormat from 'dayjs/plugin/localizedFormat';
// import advancedFormat from 'dayjs/plugin/advancedFormat';
// import isSameOrBefore from 'dayjs/plugin/isSameOrBefore';
// import isSameOrAfter from 'dayjs/plugin/isSameOrAfter';

// dayjs.extend(isToday);
// dayjs.extend(customParseFormat);
// dayjs.extend(isBetween);
// dayjs.extend(localizedFormat);
// dayjs.extend(advancedFormat);
// dayjs.extend(isSameOrBefore);
// dayjs.extend(isSameOrAfter);

let handleOutsideClick
export default {
  name: "vue-calendar-picker",
  directives: {
    closable: {
      // https://github.com/TahaSh/vue-closable // resource
      bind(el, binding, vnode) {
        // Here's the click/touchstart handler
        // (it is registered below)
        handleOutsideClick = (e) => {
          e.stopPropagation()
          // Get the handler method name and the exclude array
          // from the object used in v-closable
          const { handler, exclude } = binding.value

          // This variable indicates if the clicked element is excluded
          let clickedOnExcludedEl = false
          if (exclude) {
            exclude.forEach((refName) => {
              // We only run this code if we haven't detected
              // any excluded element yet
              if (!clickedOnExcludedEl) {
                // Get the element using the reference name
                const excludedEl = vnode.context.$refs[refName]
                // See if this excluded element
                // is the same element the user just clicked on
                clickedOnExcludedEl = excludedEl
                    ? excludedEl.contains(e.target)
                    : false
              }
            })
          }

          // We check to see if the clicked element is not
          // the dialog element and not excluded
          if (clickedOnExcludedEl && vnode.context.autoClose) {
            vnode.context[handler]()
          }
          if (!el.contains(e.target) && !clickedOnExcludedEl) {
            // If the clicked element is outside the dialog
            // and not the button, then call the outside-click handler
            // from the same component this directive is used in
            vnode.context[handler]()
          }
        }
        // Register click/touchstart event listeners on the whole page
        document.addEventListener('click', handleOutsideClick)
        document.addEventListener('touchstart', handleOutsideClick)
      },

      unbind() {
        // If the element that has v-closable is removed, then
        // unbind click/touchstart listeners from the whole page
        document.removeEventListener('click', handleOutsideClick)
        document.removeEventListener('touchstart', handleOutsideClick)
      },
    },
  },
  props: {
    value: {
      type: Array, // String || Array,
      required: false,
      default: [dayjs().format('YYYY-MM-DD')],
    },
    formatDate: {
      type: String,
      required: false,
      default: 'YYYY-MM-DD',
    },
  }
}
</script>

<style scoped>

</style>
