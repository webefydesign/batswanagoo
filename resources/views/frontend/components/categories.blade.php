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
                <ul class="multiple-items2">
                    @if(isset($meta['category']))
                        @foreach (categoriesById($meta['category']) as $cate)
                            <li>
                                <!-- <a href="{{url($cate->getSlug($cate->slug))}}"> -->
                                <a href="{{ url(generateUrl($cate->id, 'category')) }}">
                                    <div class="news-hban-box">
                                        <div class="im">
                                            <img src="{{url(($cate->image)??'#')}}" alt="{{$cate->name}}">
                                        </div>
                                        <div class="txt">
                                            <h2>{{$cate->name}}</h2>
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
