<section class="regions_sec_2">
    <div class="container">
        @if(isset($meta['heading']) || isset($meta['description']))
        <div class="row">
            <div class="col-md-12">
                <div class="sub-tit">
                    @isset($meta['heading'])
                    <h1>{{$meta['heading']}}</h1>
                    @endisset
                    @isset($meta['desc'])
                    <p>{{$meta['desc']}}</p>
                    @endisset
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="adverts_area">
                    <div class="alpabed_sec">
                        <ul>
                            @foreach(range('A', 'Z') as $alpha)
                                <li>
                                    <span>{{$alpha}}</span>
                                    <p>
                                        @foreach(allBrandPage($alpha) as $user)
                                            <a href="{{route('shop',$user->slug)}}">{{$user->name}}</a>
                                        @endforeach
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="regions_sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="b_notification">
                    <h6>{{ ($meta['text'])??'' }}</h6>
                    @if(isset($meta['btn_text']))
                    <a href="{{url(($meta['btn_link'])??'#')}}">{{($meta['btn_text'])??''}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>