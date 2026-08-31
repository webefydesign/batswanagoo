<!doctype html>
<html lang="en">
   <head>
        <title>@yield('title')</title>
      <!--== META TAGS ==-->
      @yield('seo')
      <meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <meta name="theme-color" content="#76cef1"/>      
      <!--== FAV ICON(BROWSER TAB ICON) ==-->
      <link rel="shortcut icon" href=""
         type="image/x-icon">
      <!--== GOOGLE FONTS ==-->
      <link href="https://fonts.googleapis.com/css?family=Oswald:700|Source+Sans+Pro:300,400,600,700&display=swap"
         rel="stylesheet">
      <!--== WEB ICON FONTS ==-->
      <link rel="preload" as="font" href="{{asset('assets_frontend')}}/css/icon.woff2" type="font/woff2" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--== CSS FILES ==-->
      <link rel="stylesheet" href="{{asset('assets_frontend')}}/css/jquery-ui.css">
      <link rel="stylesheet" href="{{asset('assets_frontend')}}/css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="{{asset('assets_frontend')}}/css/theme-color.php">
      <link rel="stylesheet" href="{{asset('assets_frontend')}}/css/awesome.css"  />
      <link rel="stylesheet" type="text/css" href="{{ asset('assets_frontend/css/profile.css?v=1.1') }}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets_frontend')}}/css/style.css?v=1.4">
      <link rel="stylesheet" type="text/css" href="{{asset('assets_frontend')}}/css/custom.css?v=9.7">
      <!-- favicon -->
      <link rel="icon" href="{{asset('assets_frontend')}}/fav.png" type="image/x-icon">
      <!--  <link rel="stylesheet" href="{{asset('assets_frontend')}}/css/fonts.css"> -->
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="{{asset('assets_frontend')}}/js/html5shiv.js"></script>
      <script src="{{asset('assets_frontend')}}/js/respond.min.js"></script>
      <![endif]-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
      @if(config('app.env') == 'production')
      <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-LBB3XN6Q1B"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-LBB3XN6Q1B');
        </script>
        @endif
      <style>
        .tblue{color:#0056b3 !important;}
        .userMessages {
            float: right;
            right: 292px;
            border: 1px solid #fff;
            border-radius: 70px;
            background: #fff;
            padding: 5px 7px;
            position: absolute;
            top: 4px;
        }
        .userMessages a {
            position: relative;
        }
        .userMessages a img {
            width: 20px;
        }
        .userMessages a span {
            position: absolute;
            bottom: -9px;
            right: -12px;
            font-size: 12px;
            font-weight: 100;
            border-radius: 10px;
            padding: 2px 6px;
        }
        .userNotifications {
            float: right;
            right: 350px;
            border: 1px solid #fff;
            border-radius: 70px;
            background: #fff;
            padding: 5px 7px;
            position: absolute;
            top: 4px;
        }
        .userNotifications a {
            position: relative;
        }
        .userNotifications a img {
            width: 20px;
        }
        .userNotifications a span {
            position: absolute;
            bottom: -9px;
            right: -12px;
            font-size: 12px;
            font-weight: 100;
            border-radius: 10px;
            padding: 2px 6px;
        }
        </style>

      <!-- Scripts -->
        @vite(['resources/js/app.js'])

      @yield('customStyles')
      @stack('push_css')

   </head>
   <body>
      <!-- Preloader -->
      <div id="preloader">
         <div id="status">&nbsp;</div>
      </div>

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <em class="icon ni ni-check-circle"></em> <strong>{{Session::get('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        @endif

        @if(Session::has('error'))
        <div class="alert alert-success alert-danger fade show">
            <em class="icon ni ni-check-circle"></em> <strong>{{Session::get('error')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

      @include('frontend.includes.header')

      @yield('content')

      @php
          $start_up = getConfigurations()['startup_meta'];
      @endphp
      @if(isset($start_up['show']) && $start_up['show']==1)
      <div class="modal fade startUpModal" id="startUpModal" tabindex="-1" role="dialog" aria-labelledby="startUpModalLabel" aria-modal="true" style="">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <!--<h5 class="modal-title" id="startUpModalLabel">Modal title</h5>-->
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="st-row">
                 <div class="row">
                    <div class="col-sm-12">
                         <div class="mds"><img src="{{ url(($start_up['top_image'])??'#') }}" alt="{{ ($start_up['top_image_alt'])??'Batswana Goo' }}"></div>
                    </div>
                 </div>
                 <div class="row">
                      <div class="col-sm-6" style="align-self: center;">
                          <div class="mdmg">
                              <img src="{{ url(($start_up['image'])??'#') }}" alt="{{ ($start_up['image_alt'])??'Batswana Goo' }}">
                          </div>
                      </div>
                      <div class="col-sm-6">

                            <div class="startTitle">
                               @if(isset($start_up['heading_1']))<h2>{!! ($start_up['heading_1'])??'' !!}</h2>@endif
                               @if(isset($start_up['heading_2']))<h2 class="ever">{!! ($start_up['heading_2'])??'' !!}</h2>@endif
                               @if(isset($start_up['text']))<p>{!! ($start_up['text'])??'' !!}</p>@endif
                            </div>

                            <div class="strtlnk">
                                @if(isset($start_up['btn_1_text']))<div><a href="{{ ($start_up['btn_1_link'])??'#' }}">{!! ($start_up['btn_1_text'])??'' !!}</a></div>@endif
                                @if(isset($start_up['btn_2_text']))<div><a href="{{ ($start_up['btn_2_link'])??'#' }}" class="lnkss">{!! ($start_up['btn_2_text'])??'' !!}</a></div>@endif
                            </div>
                            @if(isset($start_up['privacy_text']))
                                <p class="nt">{!! ($start_up['privacy_text'])??'' !!}
                                    @if(isset($start_up['privacy_link_text']))<a href="{{ ($start_up['privacy_link'])??'#' }}">{!! ($start_up['privacy_link_text'])??'' !!}</a>@endif
                                </p>
                            @endif
                      </div>
                  </div><!--row-->
                 </div><!--st-row-->
              </div>

          </div>
        </div>
      </div>
      @endif

      @include('frontend.includes.footer')

      <section class="add_newp nav-down">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_pan">
                        <ul>
                            <li class="">
                                <a href="{{ url('/') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path
                                            d="M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L512 185V64c0-17.7-14.3-32-32-32H448c-17.7 0-32 14.3-32 32v36.7L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1h32v69.7c-.1 .9-.1 1.8-.1 2.8V472c0 22.1 17.9 40 40 40h16c1.2 0 2.4-.1 3.6-.2c1.5 .1 3 .2 4.5 .2H160h24c22.1 0 40-17.9 40-40V448 384c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v64 24c0 22.1 17.9 40 40 40h24 32.5c1.4 0 2.8 0 4.2-.1c1.1 .1 2.2 .1 3.3 .1h16c22.1 0 40-17.9 40-40V455.8c.3-2.6 .5-5.3 .5-8.1l-.7-160.2h32z">
                                        </path>
                                    </svg>
                                    <span>Home</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ auth()->check() ? route('dashboard.my_ads') : url('login') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                        <path
                                            d="M336 0h-288C21.49 0 0 21.49 0 48v431.9c0 24.7 26.79 40.08 48.12 27.64L192 423.6l143.9 83.93C357.2 519.1 384 504.6 384 479.9V48C384 21.49 362.5 0 336 0zM336 452L192 368l-144 84V54C48 50.63 50.63 48 53.1 48h276C333.4 48 336 50.63 336 54V452z">
                                        </path>
                                    </svg>
                                    <span>My Listings</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ auth()->check() ? url('postAdd') : url('login') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path
                                            d="M200 344V280H136C122.7 280 112 269.3 112 256C112 242.7 122.7 232 136 232H200V168C200 154.7 210.7 144 224 144C237.3 144 248 154.7 248 168V232H312C325.3 232 336 242.7 336 256C336 269.3 325.3 280 312 280H248V344C248 357.3 237.3 368 224 368C210.7 368 200 357.3 200 344zM0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96zM48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80H64C55.16 80 48 87.16 48 96z">
                                        </path>
                                    </svg>
                                    <span>Post Ad</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ auth()->check() ? route('dashboard.chat') : url('login') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path
                                            d="M447.1 0h-384c-35.25 0-64 28.75-64 63.1v287.1c0 35.25 28.75 63.1 64 63.1h96v83.98c0 9.836 11.02 15.55 19.12 9.7l124.9-93.68h144c35.25 0 64-28.75 64-63.1V63.1C511.1 28.75 483.2 0 447.1 0zM464 352c0 8.75-7.25 16-16 16h-160l-80 60v-60H64c-8.75 0-16-7.25-16-16V64c0-8.75 7.25-16 16-16h384c8.75 0 16 7.25 16 16V352z">
                                        </path>
                                    </svg>
                                    <span>Messages</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ auth()->check() ? url('dashboard/profile') : url('login') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path
                                            d="M272 304h-96C78.8 304 0 382.8 0 480c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32C448 382.8 369.2 304 272 304zM48.99 464C56.89 400.9 110.8 352 176 352h96c65.16 0 119.1 48.95 127 112H48.99zM224 256c70.69 0 128-57.31 128-128c0-70.69-57.31-128-128-128S96 57.31 96 128C96 198.7 153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48z">
                                        </path>
                                    </svg>
                                    <span>My Profile</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>    



      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="{{asset('assets_frontend')}}/js/jquery.min.js"></script>
      <script src="{{asset('assets_frontend')}}/js/popper.min.js"></script>
      <script src="{{asset('assets_frontend')}}/js/bootstrap.min.js"></script>
      <!-- <script src="{{asset('assets_frontend')}}/js/jquery-ui.js"></script> -->
      <script src="{{asset('assets_frontend')}}/js/select-opt.js"></script>
     <!--  <script type="text/javascript">var webpage_full_link = '';</script>
      <script type="text/javascript">var login_url = 'login?src=jobs/';</script> -->
      <script src="{{asset('assets_frontend')}}/js/slick.js"></script>
      <script src="{{asset('assets_frontend')}}/js/custom.js"></script>
     <!--  <script src="{{asset('assets_frontend')}}/js/jquery.validate.min.js"></script>
      <script src="{{asset('assets_frontend')}}/js/custom_validation.js"></script> -->

      @yield('customScripts')

      @stack('push_script')
    @auth
    <script>
        const currentPath = window.location.pathname;

        // Run auto-refresh only if NOT on /dashboard/chat
        if (!currentPath.startsWith('/dashboard/chat')) {
            const refreshInterval = setInterval(function () {
                $.ajax({
                    url: "{{ route('dashboard.getUnreadChatCount') }}",
                    type: "GET",
                    success: function (data) {
                        $('#userMessages').html(data);
                    },
                    error: function (xhr) {
                        // Stop refreshing if unauthorized (logged out)
                        if (xhr.status === 401) {
                            console.log("User logged out, stopping refresh...");
                            clearInterval(refreshInterval);
                        }
                    }
                });
            }, 5000);
        } else {
            //console.log("Auto-refresh disabled on chat page");
        }
    </script>
    @endauth

      <script>
         $(window).scroll(function () {
             var scroll = $(window).scrollTop();
             if (scroll >= 250) {
                 $(".hom-top").addClass("dmact");
             }
             else {
                 $(".hom-top").removeClass("dmact");
             }
         });
         $('.multiple-items1').slick({
             infinite: true,
             slidesToShow: 6,
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

         $('.multiple-items2').slick({
             infinite: true,
             slidesToShow: 4,
             slidesToScroll: 1,
             autoplay: true,
             autoplaySpeed: 2500,
             responsive: [{
                 breakpoint: 992,
                 settings: {
                     slidesToShow: 1,
                     slidesToScroll: 1,
                     centerMode: false
                 }
             }]

         });

         $(".pmenu-spri ul li").mouseenter(function() {
             //console.log($(this).attr('data-name'));
             $('.pmenu-cat ul').removeClass('activeul').addClass('hideul');


             name =  $(this).attr('data-name');
             $('#'+name).removeClass('hideul').addClass('activeul');
         }).mouseleave(function() {
             //alert('hide');
         });

        $(document).on('click', '.logout-me', function() {
            $('#logOutForm').submit();
        });

        // window.onload = function() {
        //     var myModal = new bootstrap.Modal(document.getElementById('startUpModal'));
        //     myModal.show();
        // };

        document.addEventListener("DOMContentLoaded", function () {
            if (!localStorage.getItem("startUpModal")) {
                var myModal = new bootstrap.Modal(document.getElementById("startUpModal"));
                myModal.show();
                localStorage.setItem("startUpModal", "true");
            }
        });

        $(document).on('keyup', '.charCounting', function() {
            var len = $(this).val().length;
            var limit = $(this).attr('data-char');
            if (len > limit) {
                $(this).val($(this).val().substring(0, limit));
            } else {
                $(this).parent().find('.charCount').find('span').text($(this).val().length);
            }
        });

        var loadFile2 = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                $(event.target).parent().find('img').attr('src', reader.result);
            };
            if (event.target.files[0] == undefined) {} else {
                reader.readAsDataURL(event.target.files[0]);
            }
        };

        $(document).on('click', '.catSearchMakeUrl', function() {

            var _this = $(this);
            var btn = $(this).html();
            $(this).html('Searching...');
            setTimeout(() => {
                $(_this).html(btn);
            }, 3000);

            var form = $(this).parents('form');
            var url = form.attr('action');

            var make = null;
            var makeModel = null;
            var post = [];
            var field = [];
            var range_name = [];
            var range = [];
            var para = [];

            make = $(form).find('[name="make"]').val();
            makeModel = $(form).find('[name="makemodel"]').val();

            $(form).find('[name="post[]"]').each(function(k, v) {
                var val = $(v).val();
                if (val != null && val != '') {
                    post.push(val);
                }
            });
            $(form).find('[name="field[]"]').each(function(k, v) {
                var val = $(v).val();
                if (val != null && val != '') {
                    field.push(val);
                }
            });

            $(form).find('[name="range[]"]').each(function(k, v) {
                var val = $(v).val();
                var name = $(v).attr('data-name');
                if (!range_name.includes(name)) {
                    range_name.push(name);
                }
            });

            $.each(range_name, function(k, v) {
                var range_val = [];
                $(form).find('[name="range[]"][data-name="' + v + '"]').each(function(k, v) {
                    var val = $(v).val();
                    if (val != null && val != '') {
                        range_val.push(val);
                    }
                });
                if (range_val.length > 1) {
                    range.push(v + '_' + range_val.join('|'));
                }
            });


            if (make != null && make != '') {
                para.push('make=' + make);
            }
            if (makeModel != null && makeModel != '') {
                para.push('makemodel=' + makeModel);
            }
            if (post.length > 0) {
                para.push('post=' + post.join(','));
            }
            if (field.length > 0) {
                para.push('field=' + field.join(','));
            }
            if (range.length > 0) {
                para.push('range=' + range.join(','));
            }
            para = para.join('&');
            if (para != null && para != '') {
                para = '?' + para;
            }
            url = url + para;

            window.location.href = url;

        });

        // mainSearch
        $(document).on('keyup', '.mainSearch', function() {
            var name = $(this).val();
            if (name.length > 2) {
                $('.main_searching').css({
                    'opacity': '0',
                    'visibility': 'visible',
                    'z-index': '0'
                });
                jQuery.ajax({
                    url: '{{ url('mainSearching') }}',
                    type: 'post',
                    // dataType: 'html',
                    data: {
                        name: name,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('.main_searching').css({
                            'opacity': '1',
                            'transform': 'translateY(0px)',
                            'visibility': 'visible',
                            'z-index': '1',
                            'margin-top': '-2px'
                        });
                        $(".main_searching").html(data);
                    }
                });
            } else {
                $('.main_searching').css({
                    'opacity': '0',
                    'visibility': 'visible',
                    'z-index': '0'
                });
            }
        });

        $(document).on('click', '#BSearchBtn', function(){
            var url = $(this).parents('form').attr('action');
            var cat_value = $('#bcat-select-search').find('option:selected').data('url');
            var get_name = $('#bsearch-select-city').attr('name');
            var get_value = $('#bsearch-select-city').find('option:selected').val();

            console.log(url);
            console.log(cat_value);
            console.log(get_name);
            console.log(get_value);
        });

        const form = document.getElementById('job_filter_form');

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent actual submission
            
            let url = $(this).attr('action');
            const cat_value = $('#bcat-select-search').find('option:selected').data('url').replace("categories/", "");
            url = url + '/' + cat_value;

            const formData = new FormData(form);
            const formValues = {};

            let isFirstParam = true;

            for (let [key, value] of formData.entries()) {
                if (key !== 'category' && value.trim() !== '') {
                    url += (isFirstParam ? '?' : '&') + key + '=' + encodeURIComponent(value);
                    isFirstParam = false;
                }
                formValues[key] = value;
            }

            window.location.href = url;
        });


        // $(document).on('change', '#bcat-select-search', function(){
        //     var value = $(this).val();
        //     var value_name = ;
        //     $(this).parents('form').attr('action',window.location.hostname+'/'+value_name);
        // });
      </script>
   </body>
</html>
