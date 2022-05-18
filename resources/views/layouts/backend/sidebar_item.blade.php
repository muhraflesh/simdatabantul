        @foreach($items as $item)
            @if($item->hasChildren())
                <?php
                $active = '';
                $styleActive = '';
                foreach($item->children() as $children){
                    if(Request::url()==$children->url()){
                        $active = ' active open';
                        $styleActive = 'display: block;';
                        break;
                    }
                }
                ?>
                <li class="bold{{ $active }}">
                    <a class="collapsible-header waves-effect waves-cyan" href="#">
                        <i class="material-icons">{{ $item->data('icon') }}</i>
                        <span class="menu-title" data-i18n="">{!! $item->title !!}</span>    
                    </a>
                    <div class="collapsible-body" style="{{ $styleActive }}">
                        <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                            @include('layouts.backend.sidebar_item', ['items' => $item->children()])
                        </ul>
                    </div>
                </li>
            @else
                <li class="bold">
                    <a class="waves-effect waves-cyan {{ $active = (Request::url()==$item->url()) ? 'active' : ''}}" href="{{ $item->url() }}">
                        <i class="material-icons">{{ $item->data('icon') }}</i>
                        <span class="menu-title" data-i18n="">
                            {!! $item->title !!}
                        </span>
                    </a>
                </li>
            @endif

        @endforeach