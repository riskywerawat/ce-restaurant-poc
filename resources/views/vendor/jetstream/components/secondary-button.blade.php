<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-midnight-darker border border-gray-500 rounded-md font-semibold text-xs text-gray-500 uppercase tracking-widest shadow-sm hover:text-gray-400 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-400 active:dark:bg-slate-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
