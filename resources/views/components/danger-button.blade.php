<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-outline btn-error']) }}>
    {{ $slot }}
</button>
