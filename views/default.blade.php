<div class="sidebar">
    <div class="sidebar-headings">
        <ul class="nav flex-column">
            @foreach ($links as $group)
                <li class="nav-item @if ($group->getHasActiveChild()) active @endif"><a href="{!! $group->getUri() !!}" title="{!! $group->getText() !!}">{!! $group->getProp('icon') !!}<span>{!! $group->getText() !!}</span></a></li>
            @endforeach
        </ul>
    </div>

    <div class="sidebar-links">
        @foreach ($links as $group)
            @if (count($group->getLinks()))
                <ul class="nav flex-column">
                    @foreach ($group->getLinks() as $heading)
                        <li class="nav-item @if($heading->getActive() || $heading->getHasActiveChild()) active @endif"><span>{!! strtoupper($heading->getText()) !!}</span>
                            @if (count($heading->getLinks()))
                                <ul class="nav flex-column">
                                    @foreach ($heading->getLinks() as $link)
                                        <li class="nav-item @if($link->getActive() || $link->getHasActiveChild()) active @endif"><a class="nav-link" href="{!! $link->getUri() !!}">{!! $link->getText() !!}</a>
                                            @if($link->getHasActiveChild() && count($link->getLinks()))
                                                <ul class="nav flex-column">
                                                    @foreach ($link->getLinks() as $sublink)
                                                        <li class="nav-item @if($sublink->getActive()) active @endif"><a class="nav-link" href="{!! $sublink->getUri() !!}">{!! $sublink->getText() !!}</a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    </div>
</div>
