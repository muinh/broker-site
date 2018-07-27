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
    <section class="section page-header first-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner">
                        <h2>{{$page['title']}}</h2>
                        <p>CFD Trading Platform</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section page-content">
        <div class="container">
            @yield('content')
        </div>
    </section>
    @include('common.footer')
</div>
</body>
</html>