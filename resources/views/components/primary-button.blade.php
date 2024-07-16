<button {{ $attributes->merge(['type' => 'submit', 'class' => 'tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-gray-800 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest hover:tw-bg-gray-700 focus:tw-bg-gray-700 active:tw-bg-gray-900 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150']) }}>
    {{ $slot }}
</button>
