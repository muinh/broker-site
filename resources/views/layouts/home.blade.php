<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.meta')
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('/css/spot.css') }}" rel="stylesheet">
    @include('common.scripts')
</head>
<body>
<div class="body">
    @include('common.header')
    @yield('content')
    @include('common.footer')
</div>
</body>
</html>