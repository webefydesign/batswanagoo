<section class="all-list-bre brd-1">
    <div class="container sec-all-list-bre">
        <div class="row">
            <ul>
                @if(isset($meta['arr']))
                    @foreach($meta['arr'] as $i => $val1)
                        @if(array_key_last($meta['arr']) === $i)
                            <li><span>{{ ($val1['title'])??'' }}</span></li>
                        @else
                            <li><a href="{{ url(($val1['link'])??'#') }}">{{ ($val1['title'])??'' }}</a></li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</section>
