<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - Exams</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="shortcut icon" href="{{('/images/laravel_icon.svg')}}" type="image/x-icon">
        <link rel="stylesheet" href="{{asset('/fonts/font-awesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('/css/jquery.toast.css')}}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{asset('/css/style.css')}}">
        @yield('styles')

        <!-- Scripts -->
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main id="main">
                {{ $slot }}
            </main>
        </div>

        <script src="{{asset('/js/jquery.js')}}"></script>
        <script src="{{asset('/js/popper.js')}}"></script>
        <script src="{{asset('/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('/plugins/MDB/js/mdb.min.js')}}"></script>
        <script src="{{asset('/js/vue.js')}}"></script>
        <script src="{{asset('/js/vee-validate.js')}}"></script>
        <script src="{{asset('/js/jquery.toast.js')}}"></script>
        <script src="{{asset('/js/moment.js')}}"></script>
        <script src="{{asset('/js/axios.js')}}"></script>
        <script src="{{asset('/js/sweetalert.min.js')}}"></script>
        <script src="{{asset('/js/loadingoverlay.js')}}"></script>
        <script src="{{asset('/js/jquery.countdown.min.js')}}"></script>
        <script> var homepath = "{{url('/')}}";</script>

        @yield('scripts')
    </body>
</html>
