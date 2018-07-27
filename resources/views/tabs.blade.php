@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12 col-md-3 d-none d-md-block">
        {!! setting('site.side_bar_info') !!}
    </div>
    <div class="col-12 col-md-9">
        <div class="page-title"><h2>{{ array_get($page, 'title') }}</h2></div>
        <div class="page-body">
            @if (array_get($page, 'tabs'))
            <ul class="nav nav-tabs" role="tablist">
                @foreach(array_get($page, 'tabs') as $tab)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->index === 0 ? 'active' : '' }}" data-toggle="tab" href="#{{ snake_case($tab->name) }}_tab" role="tab">{!! $tab->name !!}</a>
                </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(array_get($page, 'tabs') as $tab)
                    <div class="tab-pane fade {{ $loop->index === 0 ? 'show active' : '' }}" id="{{ snake_case($tab->name) . '_tab' }}" role="tabpanel" aria-labelledby="{{ snake_case($tab->name) }}">
                        <div id="accordion_{{$tab->id}}">
                            @if (array_get($tab, 'tabItems'))
                                @foreach(array_get($tab, 'tabItems') as $tabItem)
                                    <div class="card tab-card">
                                        <div class="card-header p-0 border-bottom-0">
                                            <h5 class="mb-0">
                                                <button class="btn btn-info btn-block" data-toggle="collapse" data-target="#tab_item_{{$tabItem->id}}">
                                                    {!! $tabItem->name !!}
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="tab_item_{{$tabItem->id}}" class="collapse {{ $loop->index === 0 ? 'show' : '' }}" data-parent="#accordion_{{$tab->id}}">
                                            <div class="card-body">
                                                {!! $tabItem->content !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <div class="col-12 col-md-3 d-md-none mt-5 text-center">
        {!! setting('site.side_bar_info') !!}
    </div>
</div>
@endsection