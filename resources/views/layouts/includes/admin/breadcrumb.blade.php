@if (!empty($breadcrumbs) && is_array($breadcrumbs))
    <nav class="mb-2 block">
        <ol class="flex flex-wrap text-slate-700 text-sm">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center">

                    @unless ($loop->first)
                        <span class="px-2 text-gray-400">/</span>
                    @endunless

                    @php
                        $url = $item['href'] ?? $item['route'] ?? null;
                    @endphp

                    @if ($url)
                        <a href="{{ $url }}"
                           class="opacity-60 hover:opacity-100 transition">
                            {{ $item['name'] }}
                        </a>
                    @else
                        {{ $item['name'] }}
                    @endif

                </li>
            @endforeach
        </ol>

        @if (count($breadcrumbs) > 1)
            <h6 class="font-bold mt-2">
                {{ $breadcrumbs[array_key_last($breadcrumbs)]['name'] }}
            </h6>
        @endif
    </nav>
@endif
