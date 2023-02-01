<template>
  <Transition name="fade">
    <div v-if="showing"
         class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center z-50"
    >
      <div class="fixed inset-0 transition-opacity z-40">
        <div class="absolute inset-0 bg-gray-900 opacity-75 z-40" @click.self="close"></div>
      </div>
      <div class="relative bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6 z-50">
        <slot />
      </div>
    </div>
  </Transition>
</template>

<script>
  export default {
    name: "card-modal",
    props: {
      showing: {
        required: true,
        type: Boolean
      }
    },
    watch: {
      showing(value) {
        if (value) {
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
      }
    },
    methods: {
      close() {
        this.$emit('close');
      }
    }
  }
</script>

<style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: all 0.4s;
  }
  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }
</style>
