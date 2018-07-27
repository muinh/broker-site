@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12 col-md-3 d-none d-md-block">
        {!! setting('site.side_bar_info') !!}
    </div>
    <div class="col-12 col-md-9">
        <div class="page-title"><h2>{{$page['title']}}</h2></div>
        <div class="page-body">
            {!! $page['content'] !!}
        </div>
    </div>
    <div class="col-12 col-md-3 d-md-none mt-5 text-center">
        {!! setting('site.side_bar_info') !!}
    </div>
</div>
@endsection