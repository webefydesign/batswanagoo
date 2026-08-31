<section class="news-hom-ban-sli">
    <div class="container">
        <div class="row">
            <div class="text-center">
                <div class="sub-tit text-left">
                    <div class="sp-t">
                        <div>
                            <h2>{{($meta['title'])??''}}</h2>
                            <small>{{($meta['text'])??''}}</small>
                        </div>
                        @if(isset($meta['btn_text']))
                        <a href="{{url(($meta['btn_link'])??'#')}}">
                            {{$meta['btn_text']}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path
                                    d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z">
                                </path>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="news-hom-ban-sli-inn">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="multiple-items1">
                        @if(isset($meta['list']) && $meta['list'] == 'category' && isset($meta['category']))
                            @foreach (productsByCategoryId($meta['category']) as $ad)
                                <li>
                                    @php $img = (isset($ad->gallery) && count($ad->gallery)>0 && isset($ad->gallery[0]->mobile_img)) ? $ad->gallery[0]->mobile_img : iph(); @endphp
                                    {{-- <a href="{{ url(($ad->category ? $ad->category->getSlug($ad->category->slug ?? '') : 'uncategorized') . '/' . $ad->slug) }}"> --}}
                                    <a href="{{ url(generateUrl($ad->category_id, 'category', $ad->slug)) }}">
                                        <div class="news-hban-box">
                                            <div class="im">
                                                <img src="{{asset('uploads/post/'.$img)}}" alt="{{$ad->title}}">
                                            </div>
                                            <div class="txt">
                                                @if($ad->payment_type=='amount')
                                                <span class="news-cate">{{baseSymbol()}}{{number_format($ad->price)}}</span>
                                                @else
                                                <span class="news-cate" style="text-transform: capitalize">{{($ad->payment_type=='contact')?'Contact For Price':$ad->payment_type}}</span>
                                                @endif
                                                <h2>{{$ad->title}}</h2>
                                                <span class="news-date"><i class="fas fa-map-marker"></i> {{$ad->city}}, {{$ad->country}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @elseif (isset($meta['list']))
                            @foreach (productsByPromoId($meta['list']) as $ad)
                                <li>
                                    @php $img = (isset($ad->gallery) && count($ad->gallery)>0 && isset($ad->gallery[0])) ? $ad->gallery[0] : iph(); @endphp
                                    {{-- <a href="{{ url(($ad->category ? $ad->category->getSlug($ad->category->slug ?? '') : 'uncategorized') . '/' . $ad->slug) }}"> --}}
                                    <a href="{{ url(generateUrl($ad->category_id, 'category', $ad->slug)) }}">
                                        <div class="news-hban-box">
                                            <div class="im">
                                                {{-- <img src="{{asset('uploads/post/'.$img->mobile_img ?? '#')}}" alt="{{$ad->title}}"> --}}
                                                <picture>
                                                <source media="(max-width: 575px)" 
                                                        srcset="{{ asset('uploads/post/'.$img->mobile_img ?? '#') }}">
                                                
                                                {{-- Desktop: Use medium_img (250px) --}}
                                                    <img src="{{ asset('uploads/post/'.$img->medium_img ?? '#') }}" 
                                                         alt="{{ $ad->title }}"
                                                         loading="lazy">
                                                </picture>
                                            </div>
                                            <div class="txt">
                                                @if($ad->payment_type=='amount')
                                                <span class="news-cate">{{baseSymbol()}}{{number_format($ad->price)}}</span>
                                                @else
                                                <span class="news-cate" style="text-transform: capitalize">{{($ad->payment_type=='contact')?'Contact For Price':$ad->payment_type}}</span>
                                                @endif
                                                <h2>{{$ad->title}}</h2>
                                                <span class="news-date"><i class="fas fa-map-marker"></i> {{$ad->city}}, {{$ad->country}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

