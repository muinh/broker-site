<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.meta')
    @include('common.scripts')
</head>
<body>
    {!! array_get($page, 'content')!!}
</body>
</html>