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
        @include('components.main-content')
    </div>
    @include('components.scripts')
</body>

</html>