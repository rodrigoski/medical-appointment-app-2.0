<div class="flex space-x-1 border-b border-gray-200 mb-6">
    @foreach($tabs as $tab)
        @php
            $hasError = isset($tab['fields']) && count($tab['fields']) > 0 && $errors->hasAny($tab['fields']);
        @endphp
        <button
            type="button"
            @click="tab = '{{ $tab['key'] }}'"
            :class="tab === '{{ $tab['key'] }}'
                ? '{{ $hasError ? 'border-b-2 border-red-500' : 'border-b-2 border-indigo-600' }}'
                : 'border-b-2 border-transparent'"
            class="flex items-center space-x-2 px-4 py-3 text-sm font-medium transition
                {{ $hasError ? 'text-red-500' : 'text-gray-500' }}">

            <i class="{{ $tab['icon'] }}"></i>
            <span>{{ $tab['label'] }}</span>

            @if($hasError)
                <i class="fa-solid fa-circle-exclamation text-red-500 ml-1"></i>
            @endif

        </button>
    @endforeach
</div>
