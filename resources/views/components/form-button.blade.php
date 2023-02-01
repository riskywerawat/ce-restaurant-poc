<button {{ $attributes->merge(['type' => 'submit', 'class' => 'button button-primary disabled:opacity-25 disabled:cursor-wait']) }}>
    {{ $slot }}
</button>
