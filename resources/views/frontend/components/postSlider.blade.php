@php $rand = rand(00000,99999);
    $i = 0; @endphp
<section class="bodyType">
    <div class="container">
        <div class="row">
            <div class="sub-tit text-left">
                <div class="sp-t">
                    <div>
                        <h2>{{($meta['title'])??''}}</h2>
                        <small>{{($meta['text'])??''}}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @if(isset($meta['type']))
                    @php
                        if(isset($cate_id)){
                            $category = getCategory($cate_id);
                            $slug = generateUrl($category->id, 'category');
                        }else{
                            $slug = 'categories';
                        }
                    @endphp
                    @if($meta['type'] == 'make')
                        <ul class="hatch-ul-{{$rand}}">
                            @foreach(getMakes() as $value)
                                <li>
                                    <a href="{{url(($slug.'?make='.$value->id)??'#')}}">
                                        <img src="{{url(($value->image)??'#')}}">
                                        <strong>{{$value->name}}</strong>
                                    </a>
                                </li>
                                @php $i++; @endphp
                            @endforeach
                        </ul>
                    @elseif($meta['type'] == 'makeModel' && isset($meta['makeModel']) && count($meta['makeModel'])>0)
                        <ul class="hatch-ul-{{$rand}}">
                            @foreach(getMakeModelById($meta['makeModel']) as $value)
                                <li>
                                    <a href="{{url(($slug.'?make='.$value->make->id.'$makemodel='.$value->id)??'#')}}">
                                        <img src="{{url(($value->make->image)??'#')}}">
                                        <strong>{{$value->make->name}} {{$value->name}}</strong>
                                    </a>
                                </li>
                                @php $i++; @endphp
                            @endforeach
                        </ul>
                    @elseif($meta['type'] == 'category' && isset($meta['category']) && count($meta['category'])>0)
                        <ul class="hatch-ul-{{$rand}}">
                            @foreach(categoriesById($meta['category']) as $value)
                                <li>
                                    <a href="{{url(generateUrl($value->id, 'category'))}}">
                                        <img src="{{url(($value->icon_image)??'#')}}">
                                        <strong>{{$value->name}}</strong>
                                    </a>
                                </li>
                                @php $i++; @endphp
                            @endforeach
                        </ul>
                    @elseif($meta['type'] == 'brand' && isset($meta['brand']) && count($meta['brand'])>0)
                        <ul class="hatch-ul-{{$rand}}">
                            @foreach(brandsById($meta['brand']) as $value)
                                <li>
                                    <a href="{{url(($slug.'?post='.str_replace(' ', '_', "brand").'_'.$value->id)??'#')}}">
                                        <img src="{{url(($value->image)??'#')}}">
                                        <strong>{{$value->name}}</strong>
                                    </a>
                                </li>
                                @php $i++; @endphp
                            @endforeach
                        </ul>
                    @else
                        {{-- @php $posts = getPostByPostTypeId($meta['type'], $cate_id, 1); $ctype = get_types($meta['type']) @endphp
                        <ul class="hatch-ul-{{$rand}}">
                            @foreach($posts as $value)
                                <li>
                                    <a href="{{url(($slug.'?post='.str_replace(' ', '_', strtolower($ctype->name)).'_'.$value->id)??'#')}}">
                                        <img src="{{url(($value->image)??'#')}}">
                                        <strong>{{$value->title}}</strong>
                                    </a>
                                </li>

                                @php $i++; @endphp
                            @endforeach
                        </ul> --}}
                    @endif

                @endif
            </div>
            <!-- sm12 -->
        </div>
    </div>
</section>

@push('push_script')
    <script>
        $('.hatch-ul-{{$rand}}').slick({
            infinite: true
            , slidesToShow:5
            , slidesToScroll: 1
            , autoplay: true
            , autoplaySpeed: 3000
            , responsive: [{
                breakpoint: 992
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                    , centerMode: false
                }
            }]

        });
    </script>
@endpush
