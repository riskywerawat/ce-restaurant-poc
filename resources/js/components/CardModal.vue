<template>
  <transition
      enter-active-class="ease-out duration-300"
      enter-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="ease-in duration-200"
      leave-class="opacity-100"
      leave-to-class="opacity-0"
  >
    <div v-if="showing"
         class="fixed inset-0 w-full h-screen bg-semi-75 overflow-auto z-50 flex items-end sm:items-start justify-center"
         @click.self="close"
    >
      <transition
          enter-active-class="ease-out duration-300"
          enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="ease-in duration-200"
          leave-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      >
        <div v-if="showing"
            class="relative w-full max-h-80 md:max-h-none overflow-y-auto bg-midnight-darker m-2 mb-20 sm:mx-0 sm:my-6 shadow-lg rounded-lg p-4 sm:p-6 md:p-8"
             :class="cardClass">
          <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
            <button type="button" @click="close"
                    class="text-kimberly-link hover:text-kimberly-primary focus:outline-none focus:text-gray-500 transition ease-in-out duration-150" aria-label="Close">
              <!-- Heroicon name: x -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <slot />
        </div>
      </transition>
    </div>
  </transition>
</template>

<script>
  export default {
    name: "card-modal",
    props: {
      showing: {
        required: true,
        type: Boolean
      },
      cardClass: {
        default: 'max-w-lg',
        type: String
      }
    },
    watch: {
      showing(value) {
        if (value) {
          // console.log(window.scrollY);
          // return document.querySelector('body').classList.add('overflow-hidden');
          const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
          const body = document.body;
          body.style.position = 'fixed';
          body.style.top = `-${scrollY}`;
        } else {
          const body = document.body;
          const scrollY = body.style.top;
          body.style.position = '';
          body.style.top = '';
          window.scrollTo(0, parseInt(scrollY || '0') * -1);
        }

        // document.querySelector('body').classList.remove('overflow-hidden');
      }
    },
    methods: {
      close() {
        this.$emit('close');
      }
    }
  }
</script>

