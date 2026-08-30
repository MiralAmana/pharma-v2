@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl shadow-sm']) }}>
