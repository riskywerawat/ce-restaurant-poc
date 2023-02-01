{{--<div class="flex items-center justify-center h-screen w-screen">--}}
    {{--<button x-data="{}"--}}
            {{--x-on:click="$dispatch('notice', {type: 'success', text: '🔥 Success!'})"--}}
            {{--class="m-4 bg-green-500 text-lg font-bold p-6 py-2 text-white shadow-md rounded">--}}
        {{--Success--}}
    {{--</button>--}}
    {{--<button x-data="{}"--}}
            {{--x-on:click="$dispatch('notice', {type: 'info', text: 'ᕦ(ò_óˇ)ᕤ'})"--}}
            {{--class="m-4 bg-blue-500 text-lg font-bold p-6 py-2 text-white shadow-md rounded">--}}
        {{--Info--}}
    {{--</button>--}}
    {{--<button x-data="{}"--}}
            {{--x-on:click="$dispatch('notice', {type: 'warning', text: '⚡ Warning'})"--}}
            {{--class="m-4 bg-orange-500 text-lg font-bold p-6 py-2 text-white shadow-md rounded">--}}
        {{--Warning--}}
    {{--</button>--}}
    {{--<button x-data="{}"--}}
            {{--x-on:click="$dispatch('notice', {type: 'error', text: '😵 Error!'})"--}}
            {{--class="m-4 bg-red-500 text-lg font-bold p-6 py-2 text-white shadow-md rounded">--}}
        {{--Error--}}
    {{--</button>--}}
{{--</div>--}}
<div
        x-data="noticesHandler()"
{{--        x-init="@if(session('success'))add({type: 'success', text: '{{ session('success') }}'})@endif"--}}
        x-init="init()"
        class="fixed inset-0 flex flex-col items-end justify-start h-screen w-screen z-50 pt-24"
        x-on:notice.window="add($event.detail)"
        style="pointer-events:none">
    <template x-for="notice of notices" :key="notice.id">
        <div
                x-show="visible.includes(notice)"
                x-transition:enter="transition ease-in duration-200"
                x-transition:enter-start="transform opacity-0 translate-y-2"
                x-transition:enter-end="transform opacity-100"
                x-transition:leave="transition ease-out duration-500"
                x-transition:leave-start="transform translate-x-0 opacity-100"
                x-transition:leave-end="transform translate-x-full opacity-0"
                x-on:click="remove(notice.id)"
                class="max-w-full rounded mt-4 mr-8 sm:mr-10 lg:mr-10 px-6 py-3 flex items-center text-white shadow-lg text-sm tracking-wide cursor-pointer"
                x-bind:class="{
                    'bg-green-400': notice.type === 'success',
                    'bg-blue-400': notice.type === 'info',
                    'bg-yellow-400': notice.type === 'warning',
                    'bg-red-400': notice.type === 'error',
                 }"
                style="pointer-events:all; min-width: 20rem;"
                x-text="notice.text">
        </div>
    </template>
</div>

<script>
  function noticesHandler() {
    return {
      notices: [],
      visible: [],
      makeid(length) {
        let result = '';
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        const charactersLength = characters.length;
        for ( let i = 0; i < length; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
      },
      add(notice) {
        // notice.id = Date.now()
        notice.id = this.makeid(3)
        this.notices.push(notice)
        this.fire(notice.id)
      },
      fire(id) {
        this.visible.push(this.notices.find(notice => notice.id == id))
        const timeShown = 3000 * this.visible.length
        setTimeout(() => {
          this.remove(id)
        }, timeShown)
      },
      remove(id) {
        const notice = this.visible.find(notice => notice.id == id)
        const index = this.visible.indexOf(notice)
        this.visible.splice(index, 1)
      },
      init() {
        // for receive toast event from other js;
        document.addEventListener('toast', (event) => {
          this.add(event.detail);
        });
        @if(session('success'))
          setTimeout(() => {
            this.add({type: 'success', text: '{{ session('success') }}'});
          }, 10) // 10 ms delay (for animation)
        @endif
        @if ( $errors->all() )
          setTimeout(() => {
            this.add({type: 'error', text: '{{ $errors->first() }}'});
          }, 10)
        @endif
        @if(session('error'))
          setTimeout(() => {
            this.add({type: 'error', text: '{{ session('error') }}'});
          }, 12)
        @endif
        @if(session('info'))
          setTimeout(() => {
            this.add({type: 'info', text: '{{ session('info') }}'});
          }, 14)
        @endif
        @if(session('warning'))
          setTimeout(() => {
            this.add({type: 'warning', text: '{{ session('warning') }}'});
          }, 10)
        @endif
      }
    };
  }

  // setTimeout(() => {
  //   document.dispatchEvent(new CustomEvent('toast', {detail: {type: 'info', text: 'information na ja'}}));
  // }, 1500);
</script>
