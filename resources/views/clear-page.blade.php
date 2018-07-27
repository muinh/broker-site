@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title"><h2>{{$page['title']}}</h2></div>
        <div class="page-body">
            {!! $page['content'] !!}
        </div>
    </div>
</div>
@endsection