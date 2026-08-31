<section class="news-hom-all-lat">
    <div class="news-hom-all-lat-inn">
        <div class="container">
            <div class="row">
                <div class="sub-tit">
                    <h2>{{($meta['title'])??''}}</h2>
                    <p>{{($meta['text'])??''}}</p>
                </div>
                <div class="col-sm-2">
                    <div class="filt-com lhs-ads lhs-ads-new">
                        @if(isset($meta['image1']))
                            <div class="ads-box1">
                                <a href="{{url(($meta['side_link1'])??'#')}}">
                                    <img src="{{url(($meta['image1'])??'#')}}" alt="">
                                </a>
                            </div>
                        @endif
                        @if(isset($meta['image2']))
                            <div class="ads-box1">
                                <a href="{{url(($meta['side_link2'])??'#')}}">
                                    <img src="{{url(($meta['image2'])??'#')}}" alt="">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        @if(isset($meta['list']) && $meta['list'] == 'category' && isset($meta['category']))
                            @foreach (productsByCategoryId($meta['category'], $meta['limit']??100) as $ad)
                                @php $img = (isset($ad->gallery) && count($ad->gallery)>0 && isset($ad->gallery[0])) ? $ad->gallery[0] : iph(); @endphp
                                <div class="col-md-3">
                                    <div class="news-home-box">
                                        <div class="im">
                                            <picture>
                                                <source media="(max-width: 575px)" 
                                                        srcset="{{ asset('uploads/post/'.$img->mobile_img ?? '#') }}">
                                                
                                                {{-- Desktop: Use medium_img (250px) --}}
                                                <img src="{{ asset('uploads/post/'.$img->medium_img ?? '#') }}" 
                                                     alt="{{ $ad->title }}"
                                                     loading="lazy">
                                            </picture>
                                            {{-- <img src="{{asset('uploads/post/'.$img)}}" alt="{{$ad->title}}"> --}}
                                        </div>
                                        <div class="txt">
                                            @if($ad->payment_type=='amount')
                                                <span class="news-cate">{{baseSymbol()}}{{number_format($ad->price)}}</span>
                                            @else
                                                <span class="news-cate">{{($ad->payment_type=='contact')?'Contact For Price':$ad->payment_type}}</span>
                                            @endif
                                            <h2>{{$ad->title}}</h2>
                                            <strong>$ 250</strong>
                                            <span class="news-location"><img src="{{ asset('assets_frontend/img/icon/3.png') }}">{{$ad->city}}, {{$ad->country}}</span>
                                        </div>
                                        <!-- <a href="{{url($ad->category->getSlug($ad->category->slug).'/'.$ad->slug)}}" class="fclick"></a> -->
                                        <a href="{{ url(generateUrl($ad->category_id, 'category', $ad->slug)) }}" class="fclick"></a>
                                    </div>
                                </div>
                            @endforeach
                        @elseif (isset($meta['list']))
                            @foreach (productsByPromoId($meta['list'], $meta['limit']??100) as $ad)
                                @php $img = (isset($ad->gallery) && count($ad->gallery)>0 && isset($ad->gallery[0])) ? $ad->gallery[0] : iph(); @endphp
                                <div class="col-md-3">
                                    <div class="news-home-box">
                                        <div class="im">
                                            <picture>
                                                <source media="(max-width: 575px)" 
                                                        srcset="{{ asset('uploads/post/'.$img->mobile_img ?? '#') }}">
                                                
                                                {{-- Desktop: Use medium_img (250px) --}}
                                                <img src="{{ asset('uploads/post/'.$img->medium_img ?? '#') }}" 
                                                     alt="{{ $ad->title }}"
                                                     loading="lazy">
                                            </picture>
                                            {{-- <img src="{{asset('uploads/post/'.$img)}}" alt="{{$ad->title}}"> --}}
                                        </div>
                                        <div class="txt">
                                            @if($ad->payment_type=='amount')
                                                <span class="news-cate">{{baseSymbol()}}{{number_format($ad->price)}}</span>
                                            @else
                                                <span class="news-cate">{{($ad->payment_type=='contact')?'Contact For Price':$ad->payment_type}}</span>
                                            @endif
                                            <h2>{{$ad->title}}</h2>
                                            <strong>$ 250</strong>
                                            <span class="news-location"><img src="{{ asset('assets_frontend/img/icon/3.png') }}">{{$ad->city}}, {{$ad->country}}</span>
                                        </div>
                                        <!-- <a href="{{url($ad->category->getSlug($ad->category->slug).'/'.$ad->slug)}}" class="fclick"></a> -->
                                        <a href="{{ url(generateUrl($ad->category_id, 'category', $ad->slug)) }}" class="fclick"></a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="col-sm-12 text-center mt-4">
                        @if(isset($meta['btn_text']))
                            <a href="{{url(($meta['btn_link'])??'#')}}" class="deltabtn">
                                {{$meta['btn_text']}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
