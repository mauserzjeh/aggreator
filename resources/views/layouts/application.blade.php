<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    @include('components.styles')
</head>

<body class="bg-secondary">
    @include('components.navbar-side')

    <div class="main-content">
        @include('components.navbar-top')
        @yield('content')
    </div>
    <!-- Footer -->
    <footer class="py-5" id="footer-main">
        <div class="container">
        </div>
    </footer>
    @include('components.scripts')
</body>

</html>