<input 
    id="{{ $id }}"
    name="{{ $name }}"
    type="{{ $type }}"
    value="{{ old($name, $value) }}"
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
    @if ($required) required @endif
    @if ($autofocus) autofocus @endif
    autocomplete="{{ $autocomplete }}">
