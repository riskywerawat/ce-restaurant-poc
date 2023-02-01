<template>
  <div class="fixed z-10 inset-0 overflow-y-auto pointer-events-none" v-if="showing">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

      <transition
          enter-active-class="ease-out duration-300"
          enter-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="ease-in duration-200"
          leave-class="opacity-100"
          leave-to-class="opacity-0"
      >
        <div class="fixed inset-0 transition-opacity" v-if="showing" @click.self="close">
          <div class="absolute inset-0 bg-black opacity-75"></div>
        </div>
      </transition>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
      <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
      <transition
          enter-active-class="ease-out duration-300"
          enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="ease-in duration-200"
          leave-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      >
        <div v-if="showing"
            class="inline-block align-bottom bg-midnight-darker rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-headline">

          <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
            <button type="button" @click.self="close"
                    class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150" aria-label="Close">
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
  </div>
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

