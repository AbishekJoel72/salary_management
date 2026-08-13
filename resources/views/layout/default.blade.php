<!DOCTYPE html>
<html lang="en">
@include('layout.include.head')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<body>
    @include('layout.include.header')
    @include('layout.include.sidebar')
    <main class="main-container">
        @yield('content')
    </main>
    @include('layout.include.script')
    @include('layout.include.session')
    @yield('script')
</body>

</html>
