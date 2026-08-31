<section class="listar-sectionspace">
    <div class="news-home-box-2" style="padding: 30px 0;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="sub-tit">
                        @php $live = liveAds(); @endphp
                        <h2>{!! str_replace('[[liveAds]]', '<span>'.number_format($live).'</span>', ($meta['title'])??'') !!} </h2>
                    </div>
                </div>
            </div>
            <div class="row mobileF">
                @foreach(categories(1, 8) as $key => $category)
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="listar-categorybox">
                            <div class="listar-categorytitle">
                                <h3 onclick="window.location.href='{{ url(generateUrl($category->id, 'category')) }}'" style="cursor:pointer;"><img class="iconitite" src="{{url(($category->icon_image)??'#')}}"><span>{{$category->name}}</span></h3>
                                <small>{{allChildCount($category)}}</small>
                            </div>
                        <ul>
                            @foreach($category->childrens->take(6) as $key => $child)
                                <li>
                                    <a href="{{ url(generateUrl($child->id, 'category')) }}">
                                        <span>{{$child->name}}</span>
                                        <span>{{allChildCount($child)}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                            <div class="a-more">
                                <a href="{{ url(generateUrl($category->id, 'category')) }}">View More
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome  - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z">
                                    </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
