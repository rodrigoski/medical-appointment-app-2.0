@php
    $links = [
        [
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-gauge',
            'href' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'header' => 'Gestión',
        ],
        [
            'name' => 'Roles y permisos',
            'icon' => 'fa-solid fa-shield-halved',
            'href' => route('admin.roles.index'),
            'active' => request()->routeIs('admin.roles.*'),
        ],
    ];
@endphp

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">

    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">

            @foreach ($links as $link)
                <li>

                    {{-- Si es un header --}}
                    @isset($link['header'])
                        <div class="px-2 py-2 text-xs font-semibold text-gray-500 uppercase">
                            {{ $link['header'] }}
                        </div>
                    @else
                        {{-- Si es un enlace normal --}}
                        <a href="{{ $link['href'] }}"
                           class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $link['active'] ? 'bg-gray-100 dark:bg-gray-700' : '' }}">

                            <span class="w-6 h-6 inline-flex justify-center items-center text-gray-500">
                                <i class="{{ $link['icon'] }}"></i>
                            </span>

                            <span class="ms-3">
                                {{ $link['name'] }}
                            </span>
                        </a>
                    @endisset

                </li>
            @endforeach

            {{-- Dropdown estático --}}
            <li>
                <button type="button"
                    class="flex items-center w-full justify-between px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group"
                    aria-controls="dropdown-example"
                    data-collapse-toggle="dropdown-example">

                    <span class="flex-1 ms-3 text-left whitespace-nowrap">
                        E-commerce
                    </span>

                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="m19 9-7 7-7-7"/>
                    </svg>
                </button>

                <ul id="dropdown-example" class="hidden py-2 space-y-2">
                    <li>
                        <a href="#"
                           class="pl-10 flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                            Products
                        </a>
                    </li>
                    <li>
                        <a href="#"
                           class="pl-10 flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                            Billing
                        </a>
                    </li>
                    <li>
                        <a href="#"
                           class="pl-10 flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                            Invoice
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</aside>
