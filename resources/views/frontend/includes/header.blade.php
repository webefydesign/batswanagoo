<!-- START -->
@php
   $categories = fetchCategories();   
@endphp
<section>
  <div class="str ind2-home">
     <div  class="hom-head" style=" background-image: url('{{asset('assets_frontend/img/3261288129ex2.jpg')}}');" >
        <div class="hom-top">
           <div class="container">
              <div class="row">
                 <div class="hom-nav ">
                    <!--MOBILE MENU-->
                     <a href="{{ url('/') }}" class="top-log">
                        <img src="{{asset('assets_frontend')}}/img/logo-white.png" style="width: 160px; height: auto;" alt="" class="ic-logo">
                        <img src="{{asset('assets_frontend/img/logo-white.png')}}" style="" alt="" class="s-logo">
                     </a>
                     <div class="menu">
                        <h4>Category</h4>
                     </div>
                     <div class="pop-menu m-pop">
                        <h3>Select Category</h3>
                        <div class="container">
                           <div class="row desktop-category-menu-aa">
                                 <i class="material-icons clopme">close</i>
                                 <div class="pmenu-spri">
                                    <ul>
                                       <li data-name="ul-all"><a href="{{ url('categories') }}" class="act">
                                                <img src="{{ url($general_meta['category_img'] ?? '/sdicon.png') }}">All
                                                Categories</a>
                                       </li>
                                       @foreach ($categories as $ck => $category)
                                             <li data-name="ul-{{ $ck }}"><a
                                                   href="{{ url( generateUrl($category->id, 'category') ) }}" class="act">
                                                   <img src="{{ url($category->icon_image ?? '#') }}">
                                                   {{ $category->name }} </a>
                                             </li>
                                       @endforeach
                                    </ul>
                                 </div>
                                 <div class="pmenu-cat">
                                    <ul id="ul-all" class="hideul {{ $ck == 0 ? 'activeul' : '' }} ">
                                       @foreach ($categories as $category)
                                             <li>
                                                <a href="{{ url(generateUrl($category->id, 'category')) }}">
                                                   <!--<img class="iconi" src="https://slgoo.sl/public/assets_frontend/img/electronics.png">-->
                                                   <img class="iconi"
                                                         src="{{ url($category->icon_image ?? asset('assets_frontend/img/electronics.png')) }}">
                                                   <em>&nbsp;{{ $category->name }} -
                                                         <span class="tblue">{{ $category->filteredProducts()->count() }}</span></em>
                                                </a>
                                             </li>
                                       @endforeach
                                    </ul>

                                    @foreach ($categories as $ck => $category)
                                       <ul id="ul-{{ $ck }}"
                                             class="hideul {{ $ck == 0 ? 'activeul' : '' }} ">
                                             @foreach ($category->childrens as $child)
                                                <li>
                                                   <a href="{{ url(generateUrl($child->id, 'category')) }}">
                                                         <img class="iconi"
                                                            src="{{ url($child->icon_image ?? asset('assets_frontend/img/electronics.png')) }}">
                                                         <em>&nbsp;{{ $child->name }} -
                                                            <span class="tblue">{{ ($child->products->count()==1)?0:$child->products->count() }}</span></em></a>
                                                </li>
                                             @endforeach
                                       </ul>
                                    @endforeach

                                 </div>
                                 <div class="row mobile-menu-aa" style="">
                                    <div class="col-12">
                                       <div class="accordion" id="accordionExample">

                                             <div class="card category category-123">
                                                <div class="card-header" id="heading-123">
                                                   <h2 class="mb-0 m-accord">
                                                         <img
                                                            src="{{ url($general_meta['category_img'] ?? '/sdicon.png') }}" />
                                                         <a class="btn btn-link" href="{{url('/categories')}}">
                                                            All Categories
                                                         </a>
                                                   </h2>
                                                </div>
                                             </div>

                                             @foreach ($categories as $ck => $category)
                                                <div class="card category category-{{ $ck }}">
                                                   <div class="card-header" id="headingOne">
                                                         <h2 class="mb-0 m-accord">
                                                            <img
                                                               src="{{ url($category->icon_image ?? '#') }}" />
                                                            <a href="{{ url(generateUrl($category->id, 'category')) }}"
                                                               class="btn btn-link">
                                                               {{ $category->name }}
                                                            </a>
                                                            <span type="button" data-toggle="collapse"
                                                               data-toggle="collapse"
                                                               data-target="#collapse-{{ $ck }}"
                                                               aria-expanded="true"
                                                               aria-controls="collapse-{{ $ck }}">
                                                               <svg xmlns="http://www.w3.org/2000/svg"
                                                                     viewBox="0 0 320 512">
                                                                     <path
                                                                        d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z">
                                                                     </path>
                                                               </svg>
                                                            </span>
                                                         </h2>
                                                   </div>

                                                   <div id="collapse-{{ $ck }}" class="collapse"
                                                         aria-labelledby="heading-{{ $ck }}"
                                                         data-parent="#accordionExample">
                                                         <div class="card-body">
                                                            <ul>
                                                               @foreach ($category->childrens as $child)
                                                                     <li>
                                                                        <a href="{{ url(generateUrl($child->id, 'category')) }}">&nbsp;{{ $child->name }}
                                                                           - <span class="tblue">{{ $child->products->count() }}</span></a>
                                                                     </li>
                                                               @endforeach
                                                            </ul>
                                                         </div>
                                                   </div>
                                                </div>
                                             @endforeach
                                       </div>
                                    </div>
                                 </div>
                                 <div class="dir-home-nav-bot">
                                    <ul>
                                       @php
                                          $data = getConfigurations();
                                       @endphp
                                       <li>
                                          {{ ($data['header_meta']['h_heading'])??'' }}
                                             <span>Email us on: support@slgoo.sl</span>
                                       </li>
                                       <li>
                                             <a href="{{ ($data['header_meta']['h_btn1_link'])??'#' }}"
                                                class="waves-effect waves-light btn-large">
                                                {{ ($data['header_meta']['h_btn1_text'])??'' }}
                                             </a>
                                       </li>
                                       <li>
                                             <a href="{{ ($data['header_meta']['h_btn2_link'])??'#' }}"
                                                class="waves-effect waves-light btn-large">
                                                {{ ($data['header_meta']['h_btn2_text'])??'' }}
                                             </a>
                                       </li>
                                    </ul>
                                 </div>
                           </div>

                        </div>
                     </div>
                     <!--END MOBILE MENU-->
                     <div class="top-ser">
                        <form action="#" class="filter_form">
                            <ul>
                                <li class="sr-sea">
                                    <input type="text" class="mainSearch" autocomplete="off"
                                        id="top-select-search"
                                        placeholder="What are you looking for?">

                                    <ul id="tser-res1" class="tser-res tser-res2 main_searching">
                                    </ul>
                                </li>
                                <li class="sbtn">
                                    <button type="submit" class="btn btn-success">
                                        <i class="material-icons">&nbsp;</i>
                                    </button>
                                </li>
                            </ul>
                        </form>
                     </div>
                    <ul class="bl">
                       <!-- <li>
                          <a href="pricing-details">Add business</a>
                       </li> -->
                        @if(Auth::check())                            
                            <li>
                                <a href="{{route('postAdd')}}">Post Your Ads</a>
                            </li>
                        @else

                            <li><a class="openSignup " href="{{ route('front.login').'#register_form' }}">Sign Up</a></li>

                            <li><a class="openSignin" href="{{ route('front.login') }}">Log In</a></li>

                            <li>
                                <a href="{{ route('front.login') }}">Post Your Ads</a>
                            </li>
                        @endif
                    </ul>

                    @if(Auth::check())

                     @php
                        $plan = planData();
                        $unreadChatCount = getUnreadChatCount();                        
                     @endphp                    
                     <div id="userNotification" class="userNotifications">
                        @include('frontend.includes.notificationsButton')
                    </div>
                     <div id="userMessages" class="userMessages">
                        @include('frontend.includes.chatMessageButtton')
                    </div>
                    <div class="al">
                    <div class="head-pro">
                       <!-- <img src="{{asset('assets_frontend')}}/img/user/62736rn53themes.png" alt=""> <b>Profile by</b>
                       <br>  -->   
                        @if(isset(Auth::user()->image))
                           <img src="{{ url('/uploads/profile/'.Auth::user()->image) }}"/>
                           @else
                           <img src="{{asset('assets_frontend/fav.png')}}"/>
                           @endif                           
                        <h4>{{Auth::user()->full_name ?? ''}}</h4>
                       <a href="#" class="fclick"></a>                       
                    </div>
                    <div class="db-menu">
                        <ul> 
                           @if(auth()->user()->ads->count() > 0)
                            <li>
                                <a href="{{ route('dashboard.my_ads') }}" class="db-lact">
                                    <img src="{{asset('assets_frontend')}}/img/icon/dbl1.png" alt="" />My Listings
                                </a>
                            </li>
                            @endif                            
                            <li>
                                <a href="{{ route('dashboard.my_list') }}">
                                    <img src="{{asset('assets_frontend')}}/img/icon/dbl7.png" alt="" />My List
                                </a>
                            </li>
                            {{-- Pricing Plan link disabled - ad posting no longer requires a purchased plan.
                            <li>
                                 @if(isset($plan) && $plan !== null)
                                    <a href="{{ route('select_plan', $plan->plan->planType->name) }}">
                                 @else
                                    <a href="{{ route('select_plantype') }}">
                                 @endif
                                    <img src="{{ asset('assets_frontend/img/icon/dbl9.png') }}"
                                        alt="" />Pricing Plan</a>
                            </li>
                            --}}
                            @if(auth()->user()->ads->count() > 0)                           
                            <li>
                                <a href="{{ url('dashboard/feedback/' . auth()->user()->id) }}">
                                    <img src="{{ asset('assets_frontend/img/icon/dbl15.png') }}"
                                        alt="" />My Feedback</a>
                            </li>
                            {{-- <li>
                                <a href="{{ route('dashboard.mymsg') }}">
                                    <img src="{{asset('assets_frontend')}}/img/icon/dbl14.png" alt="" />My Inbox</a>
                            </li> --}}
                            @endif
                            <li>                                
                                <a href="{{ route('dashboard.chat') }}">
                                    <img src="{{asset('assets_frontend')}}/img/icon/dbl14.png" alt="" />My Messages
                                    @if($unreadChatCount > 0)
                                        <span class="badge badge-success">{{$unreadChatCount}}</span>
                                    @endif
                                </a>
                            </li>    
                            <li>
                                <a href="{{ route('dashboard.profile') }}">
                                    <img src="{{asset('assets_frontend')}}/img/icon/dbl4.png" alt="" />My Profile</a>
                            </li>
                            <li>
                                 <a href="{{ route('dashboard.wallet') }}" class="db-lact">
                                    <img src="{{asset('assets_frontend')}}/img/icon/dbl9.png" alt="" />My Balance <span class="badge badge-success">{{baseSymbol()}} {{number_format(auth()->user()->wallet->balance ?? 0, 2)}}</span>
                                 </a>
                           </li>
                            <li>
                                <a href="{{ route('dashboard.notifications') }}">
                                    <img src="{{asset('assets_frontend')}}/img/icon/dbl19.png" alt="" />Notifications <span class="badge badge-success">{{auth()->user()->unreadNotificationCount()}}</span></a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" id="logOutForm">
                                    {{ csrf_field() }}
                                </form>
                                <a href="javascript:void(0);" class="logout-me">
                                    <img src="{{asset('assets_frontend')}}/img/icon/dbl13.png" alt="" />Logout</a>
                            </li>
                        </ul>
                    </div>
                    </div>
                    @else
                    @endif
                    <!--MOBILE MENU-->
                    <div class="mob-menu">
                       <div class="mob-me-ic"><i class="material-icons">menu</i></div>
                       <div class="mob-me-all">
                          <div class="mob-me-clo"><i class="material-icons">close</i></div>
                          <div class="mv-bus">
                             <h4></h4>
                             <ul>

                                <li>
                                   <a href="#">Sign in</a>
                                </li>
                                <li>
                                   <a href="#">Post Free Ad</a>
                                </li>
                             </ul>
                             <div class="al">
                    <div class="head-pro">
                       <img src="{{asset('assets_frontend')}}/img/user/62736rn53themes.png" alt=""> <b>Profile by</b>
                       <br>
                       <h4>Salone Goo</h4>
                       <a href="#" class="fclick"></a>
                    </div>
                    <div class="db-menu">
                       <ul>
                          <li>
                             <a href="#" class="db-lact">
                                <img src="{{asset('assets_frontend')}}/img/icon/dbl1.png" alt="" />My Dashboard</a>
                          </li>
                          <li>
                             <a href="#">
                                <img src="{{asset('assets_frontend')}}/img/icon/dbl7.png" alt="" />All Listings</a>
                          </li>
                          <li>
                             <a href="#" class="tz-lma">
                                <img src="{{asset('assets_frontend')}}/img/icon/dbl3.png" alt="" />Add New Listing</a>
                          </li>
                          <li>
                             <a href="#">
                                <img src="{{asset('assets_frontend')}}/img/icon/dbl14.png" alt="" />Lead enquiry</a>
                          </li>
                          <li>
                             <a href="#">
                                <img src="{{asset('assets_frontend')}}/img/icon/dbl4.png" alt="" />Events</a>
                          </li>
                          <li>
                             <a href="#">
                                <img src="{{asset('assets_frontend')}}/img/icon/dbl10.png" alt="" />Blog posts</a>
                          </li>
                          <li>
                             <a href="#">
                                <img src="{{asset('assets_frontend')}}/img/icon/dbl13.png" alt="" />Reviews</a>
                          </li>
                          <li>
                             <a href="#">
                                <img src="{{asset('assets_frontend')}}/img/icon/dbl6.png" alt="" />My Profile</a>
                          </li>
                          <li>
                             <a href="#">
                                <img src="{{asset('assets_frontend')}}/img/icon/dbl12.png" alt="" />Log Out</a>
                          </li>
                       </ul>
                    </div>
                 </div>
                          </div>

                          <div class="mv-cate">
                             <h4>All Categories</h4>
                             <ul>
                                @foreach (fetchCategories() as $ck => $category)
                                    <li>
                                        <a href="{{ url($category->getSlug($category->slug) ?? '#') }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                             </ul>
                          </div>
                       </div>
                    </div>
                    <!--END MOBILE MENU-->
                 </div>
              </div>
           </div>
        </div>
        <div class="container">
           <div class="row">
              <div class="ban-tit">
                 <h1>
                    <b>Find your <span>Local needs <i></i></span></b> Restaurants, cafe's, and bars in New york
                 </h1>
              </div>
              <div class="ban-search">
                 <form name="filter_form" id="filter_form" class="filter_form">
                    <ul>
                       <li class="sr-cit">
                          <select id="city_check" name="city_check" class="chosen-select">
                             <option value="">Select City</option>
                             <option value="48025">Los Angeles</option>
                             <option value="48026">Chicago</option>
                             <option value="48027">Houston</option>
                             <option value="48028">Phoenix</option>
                             <option value="48024">New York City</option>
                             <option value="48029">Philadelphia</option>
                             <option value="48030">San Antonio</option>
                             <option value="48031">San Diego</option>
                             <option value="48032">Dallas</option>
                             <option value="48035">Illunois city</option>
                             <option selectedvalue=""></option>
                          </select>
                       </li>
                       <li class="sr-sea">
                          <input type="text" autocomplete="off" id="select-search"
                             placeholder="What are you looking for?"
                             class="search-field">
                          <ul id="tser-res" class="tser-res tser-res1">
                             <li>
                                <div>
                                   <h4>Home cleaning services near you</h4>
                                   <span>Home cleaning, pet control and more</span>
                                   <a href="#"></a>
                                </div>
                             </li>
                             <li>
                                <div>
                                   <h4>Best AC Service Expert near you</h4>
                                   <span>Service expert, ac service, ac service in new york</span>
                                   <a href="#"></a>
                                </div>
                             </li>
                             <li>
                                <div>
                                   <h4>New year 2022 celebration started</h4>
                                   <span>New year 2022, event booking, hotel booking and more</span>
                                   <a href="#"></a>
                                </div>
                             </li>
                             <li>
                                <div>
                                   <h4>Buy Iphone13 Pro now</h4>
                                   <span>Iphone 13, 12, 11 and all apple product available</span>
                                   <a href="#"></a>
                                </div>
                             </li>
                             <li>
                                <div>
                                   <h4>Now easy to buy Villas, Plots and Flats</h4>
                                   <span>New york City</span>
                                   <a href="#"></a>
                                </div>
                             </li>
                             <li>
                                <div>
                                   <h4>Spa Center For Womens</h4>
                                   <span>No:2, 4th Avenue, Newyork, USA, Near to Airport</span>
                                   <a href="#"></a>
                                </div>
                             </li>
                             <li>
                                <div>
                                   <h4>Software jobs waiting for you</h4>
                                   <span>Jobs in New york, High pay salary</span>
                                   <a href="#"></a>
                                </div>
                             </li>
                             <li>
                                <div>
                                   <h4>Online classes for School Students</h4>
                                   <span>Schools, university, colleges, online classes, tution centers, distance education..</span>
                                   <a href="#"></a>
                                </div>
                             </li>
                          </ul>
                       </li>
                       <li class="sr-btn">
                          <input type="submit" id="filter_submit" name="filter_submit"
                             value="Search" class="filter_submit">
                       </li>
                    </ul>
                 </form>
              </div>
              <div class="ban-short-links">
                 <ul>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/shop.png" alt="">
                          <h4>All Services</h4>
                          <a href="#" class="fclick"></a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/expert.png" alt="">
                          <h4>Experts</h4>
                          <a href="#" class="fclick"></a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/employee.png" alt="">
                          <h4>Jobs</h4>
                          <a href="#" class="fclick"></a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/places/icons/hot-air-balloon.png" alt="">
                          <h4>Travel</h4>
                          <a href="#" class="fclick"></a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/news.png" alt="">
                          <h4>News</h4>
                          <a href="#" class="fclick"></a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/calendar.png" alt="">
                          <h4>Events</h4>
                          <a href="#" class="fclick"></a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/cart.png" alt="">
                          <h4>Products</h4>
                          <a href="#" class="fclick"></a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/coupons.png" alt="">
                          <h4>Coupons</h4>
                          <a href="#" class="fclick"></a>
                       </div>
                    </li>
                    <!--<li>
                       <div>
                           <img src="{{asset('assets_frontend')}}/img/icon/blog1.png" alt="">
                           <h4>Blogs</h4>
                           <a href="blog-posts" class="fclick"></a>
                       </div>
                       </li>-->
                 </ul>
              </div>
              <div class="h2-ban-ql">
                 <ul>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/listing.png" alt="">
                          <h5><span
                             class="count1">12</span>All Services
                          </h5>
                          <a href="#">&nbsp;</a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/expert.png" alt="">
                          <h5><span
                             class="count1">12</span>Service Experts
                          </h5>
                          <a href="#">&nbsp;</a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/employee.png" alt="">
                          <h5><span class="count1">12</span>Jobs
                          </h5>
                          <a href="#">&nbsp;</a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/shop.png" alt="">
                          <h5><span
                             class="count1">06</span>Products
                          </h5>
                          <a href="#">&nbsp;</a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/event.png" alt="">
                          <h5><span
                             class="count1">10</span>Events
                          </h5>
                          <a href="#">&nbsp;</a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/coupons.png" alt="">
                          <h5><span
                             class="count1">07</span>Coupons
                          </h5>
                          <a href="#">&nbsp;</a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/blog.png" alt="">
                          <h5><span
                             class="count1">14</span>Blogs
                          </h5>
                          <a href="#">&nbsp;</a>
                       </div>
                    </li>
                    <li>
                       <div>
                          <img src="{{asset('assets_frontend')}}/img/icon/general.png" alt="">
                          <h5><span
                             class="count1">114</span>Community
                          </h5>
                          <a href="#">&nbsp;</a>
                       </div>
                    </li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
  </div>
</section>
@if (request()->path() != '/')
    <section>
        <div class="v3-list-ql">
            <div class="container">
                <div class="row">
                    <div class="v3-list-ql-inn">
                        <ul>
                            @foreach (categories(1, 7) as $category)
                                {{-- @php $cateslug = ($category->page->slug)??generateUrl($category->id, 'page'); @endphp --}}
                                <li>
                                    <div>
                                        <img src="{{ url($category->icon_image ?? '#') }}">
                                        <h4>{{ $category->name }}</h4>
                                        <a href="{{ url(generateUrl($category->id, 'page')) }}" class="fclick"></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-- END -->

<style>
  .hom-head .container{display:none}
  .hom-top{transition:all .5s ease;background:#000;box-shadow:none}
  .hom-head{background:none!important;padding:0;margin:0}
  .hom-head .hom-top .container{display:block}
  .dmact .top-ser{display:block}
  .hm3-auto-ban{background:url(img/automobile-bg.jpg) no-repeat;background-size:100%;background-position:center right;padding-top:55px}
  .h2-ban-ql{display:table}
  .hm3-auto-ban .rhs .hom-col-req .log-bor{display:block}
  .caro-home{margin-top:90px;float:left;width:100%}
  .carousel-item:before{background:none}
  .ban-tit h1{font-weight:500;color:#fff;text-shadow:none}
  .ban-tit h1 b{font-weight:700;font-size:42px;line-height:49px;padding-bottom:15px;color:#fff;text-shadow:none}
  .h2-ban-ql ul li div{border:1px solid #d9d9da;background:#fff}
  .h2-ban-ql ul li div h5{font-weight:500;color:#383942}
  .h2-ban-ql ul li div h5 span{font-weight:700}
  .home-tit h2{font-weight:400}
  .home-tit h2 span{font-weight:700}
  .h2-ban-ql ul li div:hover{background:#d3f0fb;box-shadow:0 14px 22px -13px #0b1017ba}
  .land-pack-grid-text{position:relative;-webkit-transition:all .5s ease;-moz-transition:all .5s ease;-o-transition:all .5s ease;transition:all .5s ease;position:absolute;top:0;bottom:0;left:0;right:0;width:100%;height:100%;z-index:2;background:linear-gradient(to top,#000000c7,#00000008)}
  .land-pack-grid-text h4{padding:15px;font-size:20px;font-weight:400;text-align:center;bottom:0;position:absolute;width:100%;text-align:center;color:#fff}
  .land-pack-grid-text h4 .dir-ho-cat{color:#f6f7f9;font-size:11px;position:relative;width:100%;display:inline-block}
  .land-pack-grid-img{background:#333}
  .home-tit{padding-top:60px}
  .hom2-hom-ban{float:left;width:46%;background-size:cover;margin:0 2%;background:#e6f6fb;padding:30px 100px 30px 30px;border-radius:5px;position:relative}
  .hom2-hom-ban:hover a{background:#d6c607}
  .hom2-hom-ban h2{font-weight:600;font-size:22px;padding-bottom:5px}
  .hom2-hom-ban p{font-size:14px}
  .hom2-hom-ban a{background:#21d78d;color:#fff;padding:10px 20px;border-radius:5px;display:inline-block;cursor:pointer;font-size:13px;font-weight:400}
  .hom2-hom-ban p,.hom2-hom-ban h2,.hom2-hom-ban a{position:relative;color:#fff}
  .hom2-hom-ban:before{content:'';position:absolute;width:100%;height:100%;left:0;top:0;right:0;bottom:0;z-index:0;opacity:.8;background:#24C6DC;border-radius:5px}
  .hom2-hom-ban1:before{background-image:linear-gradient(140deg,#0c7ada 0%,#0761af 50%,#0f243e94 75%)}
  .hom2-hom-ban2:before{background-image:linear-gradient(140deg,#768404 0%,#768404 50%,#0f243e94 75%)}
  .hom2-hom-ban1{background-image:url(../img/home2-hand.jpg)}
  .hom2-hom-ban2{background-image:url(../img/home2-work.jpg)}
  .hom2-hom-ban-main{float:left;width:100%;padding-bottom:70px}
  .hom2-cus-sli{float:left;width:100%;padding-top:0}
  .hom2-cus-sli ul li{float:left;width:25%;padding:12px 20px}
  .testmo{width:100%;background:#fff;box-shadow:0 1px 7px -3px #161d2926;border-radius:5px;padding:30px;position:relative}
  .testmo img{width:64px;height:64px;border-radius:50px;object-fit:cover;margin:-80px 0 0}
  .testmo h4{font-size:14px;font-weight:600;margin-bottom:2px;}
  .testmo span{font-size:11px;font-weight:400;color:#727688}
  .testmo span a{font-weight:500;color:#4caf50;display:block;font-size:12px}
  .testmo p{color:#727688;font-size:12px;line-height:20px;margin:0;font-weight:400;height:58px;overflow:hidden;border-top:1px solid #f1eeee;padding-top:15px;margin-top:15px}
  .testmo p:before{content:'format_quote';font-size:21px;margin:-25px 0 0;background:#fff}
  .hom2-cus{background:#f7f8f9;padding-bottom:70px}
  .testmo .rat{padding:2px 2px 2px 10px;display:inline-block;position:absolute;right:30px;top:50px}
  .testmo .rat i{color:#FF9800;font-size:13px;width:7px}
  .hom2-cus-sli ul{position:relative;overflow:hidden;padding:20px 20px 0}
  .slick-arrow{width:50px;height:50px;border-radius:50px;background:#fff;border:1px solid #ededed;color:#ffffff03;position:absolute;z-index:9;top:38%}
  .slick-arrow:before{content:'chevron_left';font-size:27px;top:4px;left:9px}
  .slick-prev{left:14px}
  .slick-next{right:14px}
  .slick-next:before{content:'chevron_right';font-size:27px}
  .hom4-prop-box{padding:0;background:#fff;box-shadow:0 1px 14px -4px #161d2926;border:1px solid #efefef}
  .hom4-prop-box img{width:100%;border-radius:2px;margin:0;height:120px}
  .hom4-prop-box div{padding:25px}
  .hom4-prop-box .rat{position:relative;top:initial;right:initial;padding:2px 2px 2px 0;display:block;margin:0;height:17px;left:-2px}
  .hom4-fea{background:#fff;padding-bottom:40px}
  .hom4-fea .hom2-cus-sli ul li{padding:12px 20px}
  .hom4-fea .home-tit{margin-bottom:0;padding-top:70px}
</style>
