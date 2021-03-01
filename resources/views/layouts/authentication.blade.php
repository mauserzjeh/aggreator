<!DOCTYPE html>
    <head>
    </head>
    <body>
        @if(session('error'))
        <div>{{ session('error') }}</div>
        @endif
        @if(session('success'))
        <div>{{ session('success') }}</div>
        @endif
        @yield('content')
    </body>
</html>