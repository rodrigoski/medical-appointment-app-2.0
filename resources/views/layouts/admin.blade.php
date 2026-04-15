<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/c70db31e3e.js" crossorigin="anonymous"></script>

    <!-- WireUI -->
    <wireui:scripts />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-50">

    @include('layouts.includes.admin.navigation')
    @include('layouts.includes.admin.sidebar')

 <div class="p-4 sm:ml-64 mt-14">
    <div class="mt-14 flex justify-between items-center w-full">
        @include('layouts.includes.admin.breadcrumb')
        @isset($action)
            <div>
                {{ $action }}
            </div>
        @endisset
   <main>
    @yield('content')
</main>

    {{-- SweetAlert desde sesión --}}
    @if (session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif

    @stack('modals')

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

    <script>
        //BUsca todos los elementos para borrar
        forms = document.querySelectorAll('.delete-form');
        forms.forEach(form =>{
            form.addEventListener('submit', function(e){
                //No borrar
                Swal.fire({
                title: "¿Estás seguro?",
                text: "No podrás revertir esto",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

</body>
</html>
