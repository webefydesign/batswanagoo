<section class="news-hom-all-lat news">
    <div class="news-hom-all-lat-inn">
       <div class="container">
          <div class="row">
             <div class="sub-tit text-left">
                <div class="sp-t">
                   <div>
                      <h2>{{ ($meta['title'])??'' }}</h2>
                   </div>
                    @if(isset($meta['btn_text']))
                        <a href="{{url(($meta['btn_link'])??'#')}}">
                            {{ ($meta['btn_text'])??'' }}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z">
                                </path>
                            </svg>
                        </a>
                    @endif
                </div>
             </div>
             <div class="row mt-3">
                @foreach(getBlogs(3) as $blog)
                    <div class="col-md-4">
                        <div class="news-home-box">
                        <div class="im">
                            <img src="{{url($blog->image) }}" alt="{{$blog->title}}">
                        </div>
                        <div class="txt">
                            @foreach($blog->categories as $key => $cat)
                                <span class="news-cate"> {{$cat->title}} </span>
                            @endforeach
                            <h2>{{$blog->title}}</h2>
                            <span class="news-date">{{date('d, M Y', strtotime($blog->created_at))}}</span>
                            <span class="news-views">{{$blog->views}} Views</span>
                        </div>
                        <a href="{{url('blog/'.$blog->slug)}}" class="fclick"></a>
                        </div>
                    </div>
                @endforeach
             </div>
          </div>
       </div>
    </div>
 </section>
