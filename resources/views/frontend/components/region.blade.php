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

            @foreach(getStates(29) as $k => $state)
                <div class="col-md-12">
                    <div class="adverts_area">
                        @php $cities = getCities(29, $state); @endphp
                        <div class="ada_top">
                            <h4>{{$k}} Province</h4>
                            <a href="{{url('categories?page=1&country=29&state='.$state)}}">See all {{$k}} cities (<span class="tblue">{{adsInLocation($k, 'state')}}</span>)</a>
                        </div>
                        <div class="cities_sec">
                            <ul>
                                @foreach($cities as $c => $city)
                                <li><a href="{{url('categories?page=1&country=29&state='.$state.'&city='.$city)}}">{{$c}}</a> (<span class="tblue">{{adsInLocation($c, 'city')}}</span>)</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach

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
