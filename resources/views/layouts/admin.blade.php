@props([
    'title' => null,
    'breadcrumbs' => [],
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @livewireStyles
    <wireui:scripts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://kit.fontawesome.com/c70db31e3e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">

    @include('layouts.includes.admin.navigation')
    @include('layouts.includes.admin.sidebar')

    <div class="p-4 sm:ml-64 mt-14">
        <div class="flex justify-between items-center w-full mb-6">
            @include('layouts.includes.admin.breadcrumb')
            @isset($action)
                <div>{{ $action }}</div>
            @endisset
        </div>

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    @stack('scripts')

    <script>
        @if (session('swal'))
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire(@json(session('swal')));
            });
        @endif

        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('delete-form')) {
                e.preventDefault();
                const form = e.target;

                Swal.fire({
                    title: "Estas seguro?",
                    text: "No podras revertir esto",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Si, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    </script>
    <script>
    @if (session('swal'))
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire(@json(session('swal')));
        });
    @endif

    {{-- NUEVO: disparar swal cuando hay errores de validación --}}
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: '¡Datos incorrectos!',
                html: `<ul class="text-left text-sm text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>`,
                icon: 'error',
                confirmButtonColor: '#4f46e5',
                confirmButtonText: 'Entendido',
            });
        });
    @endif

    document.addEventListener('submit', function(e) {
        if (e.target.classList.contains('delete-form')) {
            e.preventDefault();
            const form = e.target;

            Swal.fire({
                title: "Estas seguro?",
                text: "No podras revertir esto",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
</script>
</body>
</html>
