<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-400 border border-transparent rounded-lg font-semibold text-sm text-gray-900 hover:from-yellow-600 hover:to-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg']) }}>
    {{ $slot }}
</button>
