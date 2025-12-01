<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page-name')</title>

    <!-- Font Awesome CDN -->
    <script src="https://kit.fontawesome.com/b628ba4512.js" crossorigin="anonymous"></script>

    <!-- Vite CSS and JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    @include('frontend.template.navbar')

    <div class="flex pt-20">
        <!-- Sidebar -->
        @include('frontend.template.sidebar')

        <!-- Main Content -->
        <main class="ml-64 w-full p-8">
            @yield('main-content')
        </main>
    </div>
</body>

</html>
