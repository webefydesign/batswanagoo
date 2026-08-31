<section class="all-list-bre searchbanner" @if(isset($meta['bg'])) style="background-image: url('{{url(($meta['bg'])??'#')}}');" @endif>
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
            @if(isset($meta['title1'])) <h2>{{$meta['title1']}}</h2> @endif
            @if(isset($meta['title2'])) <h1>{{$meta['title2']}}</h1> @endif
        </div>
    </div>
</section>

