<button {{ $attributes->merge(['type' => 'button', 'class' => 'tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-white tw-border tw-border-gray-300 tw-rounded-md tw-font-semibold tw-text-xs tw-text-gray-700 tw-uppercase tw-tracking-widest tw-shadow-sm hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 disabled:tw-opacity-25 tw-transition tw-ease-in-out tw-duration-150']) }}>
    {{ $slot }}
</button>
