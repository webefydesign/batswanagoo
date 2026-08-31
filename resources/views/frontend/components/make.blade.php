@php $rand = rand(000,999); @endphp
<section class="makesmodal">
    <div class="container">
        <div class="row">
            <div class="sub-tit text-left">
                <div class="sp-t">
                    <div>
                        <h2>{{($meta['title'])??''}}</h2>
                        <small>{{($meta['text'])??''}}</small>
                    </div>
                    @if(isset($meta['btn_text']))
                    <a href="{{url(($meta['btn_link'])??'#')}}">
                        {{$meta['btn_text']}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <ul class="bms bms-{{$rand}}">
                    @if(isset($meta['show']) && $meta['show'] == 'makeModel' && isset($meta['makes']))
                        @php
                            if(isset($meta['category'])){
                                $category = getCategory($meta['category']);
                                $slug = generateUrl($category->id, 'category');
                            }else{
                                $slug = 'categories';
                            }
                        @endphp
                        @foreach(getMakeById($meta['makes']) as $make)
                            <li>
                                <div class="licon">
                                    <img src="{{url((getThumb($make->image))??'#')}}">
                                    {{$make->name}}
                                </div>
                                @if(count($make->make_model)>0)
                                <ul>
                                    @foreach($make->make_model->take(4) as $model)
                                    <li><a href="{{url(($slug.'?make='.$make->id.'&makemodel='.$model->id)??'#')}}">{{$model->name}}</a></li>
                                    @endforeach
                                    <li><a href="{{url(($slug.'?make='.$make->id)??'#')}}">See all</a></li>
                                </ul>
                                @endif
                            </li>
                        @endforeach
                    @elseif(isset($meta['show']) && $meta['show'] == 'category' && isset($meta['category']))
                        @php
                            $category = getCategory($meta['category']);
                            $category = $category[array_key_first(array($category))];
                        @endphp
                        @foreach($category->childrens as $cate)
                            <li>
                                <div class="licon">
                                    <img src="{{url(($cate->icon_image)??'#')}}">
                                    <span><a href="{{url(generateUrl($cate->id, 'category'))}}">{{$cate->name}}</a></span>
                                </div>
                                @if(count($cate->childrens)>0)
                                <ul>
                                    @foreach($cate->childrens->take(4) as $child)
                                    <li><a href="{{url(generateUrl($child->id, 'category'))}}">{{$child->name}}</a></li>
                                    @endforeach
                                    <li><a href="{{url(generateUrl($child->id, 'category'))}}">See all</a></li>
                                </ul>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <!-- sm12 -->
        </div>
        <!-- row -->
    </div>
</section>
@if(isset($meta['slider']) && $meta['slider'] == 'slider')
    @push('push_script')
        <script>
        if ($(window).width() > 767) {
            var rand = '{{$rand}}';
            if ($('.bms-'+rand+' > li').length > 5) {

                $('.bms-'+rand).slick({
                    infinite: true,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    responsive: [{
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerMode: false
                        }
                    }]

                });
            }
        }
        </script>
    @endpush
@endif
