<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 bg-highlight border border-transparent rounded-md font-bold text-sm text-white uppercase tracking-widest hover:bg-highlight-pressed active:bg-highlight-pressed focus:outline-none focus:border-midnight-border focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
