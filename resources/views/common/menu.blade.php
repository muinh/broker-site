<ul @if(isset($baseNode) && count(array_get($baseNode, 'nodes')) > 0) class="sub-menu" @endif>
    @foreach($menuItems as $menuItem)
        <li class="menu-item {{ array_get($menuItem, 'class') }} @if(isset($menuItem) && count(array_get($menuItem, 'nodes')) > 0) menu-item-has-children @endif">
            <a href="{{array_get($menuItem, 'url')}}" class="menu-link  @if(link_active(array_get($menuItem, 'url'))) active @endif">{!! array_get($menuItem, 'title') !!}</a>
            @includeWhen(count(array_get($menuItem, 'nodes')) > 0, 'common.menu', ['menuItems' => array_get($menuItem, 'nodes'), 'baseNode' => $menuItem])
        </li>
    @endforeach
</ul>