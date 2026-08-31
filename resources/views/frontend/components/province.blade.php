<section class="province">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>{{($meta['title'])??''}}</h2>
                @if(isset($meta['slide']) && isset($meta['category']))
                <ul>
                    @if($meta['slide'] == 'country')
                        @php
                            $category = getCategory($meta['category']);
                        @endphp
                        <li style="margin-bottom:10px;"><a href="{{url($category->slug)}}">All Country</a></li>
                        @foreach(getCountry() as $country)
                            <li style="margin-bottom:10px;"><a href="{{url($category->slug.'?country='.$country->id)}}">{{$country->name}}</a></li>
                        @endforeach
                    @elseif($meta['slide'] == 'state' && isset($meta['country']))
                        @php
                            $category = getCategory($meta['category']);
                            $country = country($meta['country']);
                        @endphp
                        {{-- <li style="margin-bottom:10px;"><a href="{{url($category->slug.'?country='.$country->id)}}">{{$country->name}}</a></li> --}}
                        @foreach(getStates($meta['country']) as $st => $state)
                            <li style="margin-bottom:10px;"><a href="{{url('categories/'.$category->slug.'?country='.$country->id.'&state='.$state)}}">{{$st}}</a></li>
                        @endforeach
                    @elseif($meta['slide'] == 'city' && isset($meta['state']))
                        @php
                            $category = getCategory($meta['category']);
                            $country = country($meta['country']);
                            $state = state($meta['state']);
                        @endphp
                        <li style="margin-bottom:10px;"><a href="{{url($category->slug.'?country='.$country->id.'&state='.$state->name)}}">{{$state->name}}</a></li>
                        @foreach(getCitiesByStateName(($state['name'])??'') as $city)
                            <li style="margin-bottom:10px;"><a href="{{url($category->slug.'?country='.$country->id.'&state='.$state->name.'&city='.$city->name)}}">{{$city->name}}</a></li>
                        @endforeach
                    @endif
                </ul>
                @endif
            </div><!-- sm12 -->
        </div>
    </div>
</section>
