<div class="flex space-x-1 border-b border-gray-200 mb-6">
    @foreach($tabs as $tab)
        <button
            type="button"
            @click="tab = '{{ $tab['key'] }}'"
            :class="tab === '{{ $tab['key'] }}' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500 hover:text-gray-700'"
            class="flex items-center space-x-2 px-4 py-3 text-sm font-medium transition">
            <i class="{{ $tab['icon'] }}"></i>
            <span>{{ $tab['label'] }}</span>
        </button>
    @endforeach
</div>
