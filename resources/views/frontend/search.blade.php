@extends('layouts.frontend')
@section('title', (!empty($data['seo']['meta_title']))?$data['seo']['meta_title']:$all_parent_categories[count($all_parent_categories) - 1]['name'].' | Batswana Goo')
{{-- @section('title', (!empty($data['seo']['meta_title']))?$data['seo']['meta_title']:$all_parent_categories[count($all_parent_categories) - 1]['name'].' | Batswana Goo') --}}
@section('seo')
    @include('frontend.seo', [ 'description'=>$data['seo']['meta_desc']??'', 'schema'=>$data['seo']['schema_code']??'', 'seo'=>$data['seo']??[] ])
@endsection

@section('customStyles')
    <style>
        .success_offer_send{
            font-size: 12px;
            line-height: 15px;
            color: green;
            text-align: center;
            padding-top: 15px;
            font-weight: 500;
            display: none;
        }
        .sCategory, .sCountry, .sState, .sCity{
            cursor: pointer;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .sMake, .sPost{
            cursor: pointer;
            width: 100%;
            display: flex;
        }
        .sCategory .ccount, .sCountry .ccount ,.sState .ccount ,.sCity .ccount{
            font-size: 10px;
            color: #bcbcbc;
        }
        .sField_label{
            background: #ffffff;
            color: #5e5e5e;
            text-align: center;
            padding: 3px 11px;
            border-radius: 4px;
            cursor: pointer;
            border: solid 1px #dfdfdf;
            font-size: 11px;
            font-weight: 500;
        }
        .sField_label input{
            visibility: hidden;
            position: absolute;
        }
        .field_check1{
            display: inline-block;
        }
        .sMake img, .sPost img{
            width: 20px;
            height: 20px;
            object-fit: contain;
            margin-right: 10px;
        }
        .searching{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: #0000005e;
            z-index: 4;
            display: none;
        }
        .ccount{color:#0056b3 !important;}
        #side-categories .checkbox {
            display: none;
        }

        #side-categories .checkbox:nth-child(-n+5) {
            display: block;
        }
    </style>
@endsection

@section('content')

    @php $general_meta = getConfigurations(); @endphp

    <div class="searching"></div>

    <div class="overlay-filtermobile"></div>
    <section class="all-list-bre brd-1" >
        <div class="container sec-all-list-bre">
            <div class="row breadcrumbs-render-html">
                @include('frontend.includes.ads_listing', ['type'=>'breadcrumbs'])
            </div>
        </div>
    </section>
    <section style="position:relative;" class="mb-f">
        <div class="search-filters-panel-mobile-aa ani" style="display:none"></div>
        <div class="all-listing all-listing-pg for-counting" @if(isset($general_meta['search_meta']['bg'])) style="background:url('{{url(($general_meta['search_meta']['bg'])??'#')}}') no-repeat #5085f7;background-size:cover;background-attachment: fixed;" @endif>
            <!--FILTER ON MOBILE VIEW-->
            <div class="fil-mob fil-mob-act">
                <h4>Listing filters <i class="material-icons">filter_list</i></h4>
            </div>
            <div class="all-list-bre">
                <div class="container sec-all-list-bre">
                    <div class="row count-render-html countingbg">
                        @include('frontend.includes.ads_listing', ['type'=>'count'])
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 fil-mob-view">
                        <!-- <h3>Filter By</h3> -->

                        <div class="filter-menu">

                                <div class="panel panel-default ">
                                    <div class="panel-heading filterdesktoppanel">

                                        <div class="panel-body">
                                            <div class="mobilefle">
                                                <div class="fle">
                                                    <button class="btn btn-default filter resetbt" type="button">Apply Filters</button>
                                                    <a class="btn btn-sm btn-link clears pull-right visible-sm-inline donbt"
                                                        href="javascript:void(0);">Clear</a>
                                                </div>
                                            </div>
                                        </div><!-- /.panel-body -->
                                    </div><!-- /.panel-heading -->

                                    <div class="panel-body sidebar-render-html">
                                        @include('frontend.includes.ads_listing', ['type'=>'sidebar'])
                                    </div><!-- /.panel-body -->
                                </div><!-- /.panel -->

                                  <div class="panel-heading filterMobilediv">
                                        <div class="panel-body">
                                            <div class="mobilefle">
                                                <div class="fle">
                                                    <button class="btn btn-default filter resetbt mbt-apply" type="button">Apply Filters</button>
                                                    <a class="btn btn-sm btn-link clears pull-right visible-sm-inline donbt"
                                                        href="javascript:void(0);">Clear</a>
                                                </div>
                                            </div>
                                        </div><!-- /.panel-body -->
                                    </div><!-- /.panel-heading -->

                        </div><!-- /.filter-menu -->

                    </div><!-- md3 -->
                    <div class="col-md-9">
                        <div class="f2">
                            <div class="vfilter"> <i class="material-icons ic1 " title="Grid view">apps</i>
                                <i class="material-icons ic2 act" title="List view">format_list_bulleted</i>
                                <i class="material-icons ic3" title="Map view">location_on</i>
                            </div>
                        </div>
                        <!-- LISTING INN FILTER -->

                        <!-- END LISTING INN FILTER -->
                        <!--ADS-->
                        <div class="s-ll">
                            <div class="sorts">
                                <label>Sort By</label>
                                <select name="sort" class="changeSort">
                                    <option value="recent">Most Recent</option>
                                    <option value="low_price">Low Prices</option>
                                    <option value="high_price">High Prices</option>
                                    <option value="call_for_price">Call For Price</option>
                                    <option value="old">Oldest</option>
                                </select>
                            </div>
                            <a href="javascript:;" class="btn-show-filters-aa"></a>
                        </div>
                        @if(isset($general_meta['search_meta']['ad_1']))
                        <div class="ban-ati-com ads-all-list">
                            <a href="{{url(($general_meta['search_meta']['ad_link_1'])??'#')}}"><span>Ad</span><img src="{{url(($general_meta['search_meta']['ad_1'])??'#')}}" alt="">
                            </a>
                        </div>
                        @endif
                        <!--ADS-->
                        <!-- Loader Image -->
                        <div id="loadingmessage" style="display:none">
                            <div id="loadingmessage1">&nbsp;</div>
                        </div>
                        <!-- Loader Image -->
                        <div class="all-list-sh all-listing-total formobileLst" >

                            <div class="list-render-html">
                                @include('frontend.includes.ads_listing', ['ads' => $ads, 'type'=>'listing'])
                            </div>


                            @if(isset($general_meta['search_meta']['ad_2']))
                            <div class="ban-ati-com ads-all-list">
                                <a href="{{url(($general_meta['search_meta']['ad_link_2'])??'#')}}"><span>Ad</span><img src="{{url(($general_meta['search_meta']['ad_2'])??'#')}}" alt=""> </a>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- @if(isset($general_meta['search_meta']['bg_2']))
        <section>
            <div class="full-bot-book" style="background:url('{{url(($general_meta['search_meta']['bg_2'])??"#")}}') #7f878c;background-size: 700px;">
                <div class="container">
                    <div class="row">
                        <div class="bot-book">
                            <div class="col-md-12 bb-text">
                                <h4>{!! ($general_meta['search_meta']['h1'])??'' !!}</h4>
                                <p>{!! ($general_meta['search_meta']['p'])??'' !!}</p>
                                @if(isset($general_meta['search_meta']['btn_txt']))
                                <a href="{{url(($general_meta['search_meta']['btn_link'])??'#')}}"> {{$general_meta['search_meta']['btn_txt']}} <i class="material-icons">arrow_forward</i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif --}}

@endsection

@section('customScripts')
<script>
    var page = '{{($_GET['page'])??''}}';
    var sort = '{{($_GET['sort'])??''}}';
    var category = '{{($_GET['category'])??''}}';
    var country = '{{($_GET['country'])??''}}';
    var state = '{{($_GET['state'])??''}}';
    var city = '{{($_GET['city'])??''}}';
    var min = '{{($_GET['min'])??''}}';
    var max = '{{($_GET['max'])??''}}';
    var make = '{{($_GET['make'])??''}}';
    var makemodel = '{{($_GET['makemodel'])??''}}';
    var post = '{{($_GET['post'])??''}}';
    var field = '{{($_GET['field'])??''}}';
    var range = '{{($_GET['range'])??''}}';


    if(category == null || category == ''){
        category = '{!! ($category->slug)??'' !!}';
    }else{
        category = 'categories';
    }

    post = (post=='' || post==null)?[]:post.split(",");
    field = (field=='' || field==null)?[]:field.split(",");
    range = (range=='' || range==null)?[]:range.split(",");

    $(document).on('change', '.changeSort',function(e){
        e.preventDefault();
        var val = $(this).val();
        sort = val
        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.sCategory',function(e){
        e.preventDefault();
        var val = $(this).attr('data-val');
        if(val == 0){
            category = 'categories';
        }else{
            category = val
        }
        make = null;
        makemodel = null;
        post = [];
        field = [];
        range = [];
        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.sCountry',function(e){
        e.preventDefault();
        var val = $(this).attr('data-val');
        if(val == 0){
            country = null;
        }else{
            country = val
        }

        state = null;
        city = null;
        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.sState',function(e){
        e.preventDefault();
        var val = $(this).attr('data-val');
        if(val == 0){
            state = null;
        }else{
            state = val
        }
        city = null;

        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.sCity',function(e){
        e.preventDefault();
        var val = $(this).attr('data-val');
        if(val == 0){
            city = null;
        }else{
            city = val
        }
        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.changePara',function(e){
        e.preventDefault();
        var field = $(this).attr('data-para');
        var val = $(this).attr('data-val');
        if(field == 'country'){
            country = val;
        }else if(field == 'state'){
            state = val;
        }else if(field == 'city'){
            city = val;
        }else if(field == 'country'){
            country = val;
        }

        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.priceSearch', function(e){
        e.preventDefault();
        var minV = $('.minValue').val();
        var maxV = $('.maxValue').val();
        if(minV != null && maxV != null){
            min = minV;
            max = maxV;
        }
        page = 1;
        filterAds(page);
    })

    $(document).on('click', '.sMake',function(e){
        e.preventDefault();
        var val = $(this).attr('data-val');
        if(val == 0){
            make = null;
        }else{
            make = val
        }

        makemodel = null;
        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.sMakeModel',function(e){
        e.preventDefault();
        var val = $(this).attr('data-val');
        if(val == 0){
            makemodel = null;
        }else{
            makemodel = val
        }
        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.clears', function(){
        sort = null;
        country = null;
        state = null;
        city = null;
        min = null;
        max = null;
        make = null;
        makemodel = null;
        post = [];
        field = [];
        range = [];
        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.sPost',function(e){
        e.preventDefault();
        var val = $(this).attr('data-val');
        var slug = $(this).attr('data-post');

        if(val == 0){
            post = [];
        }else if(post.length == 0 && val != 0){
            post.push(slug+'_'+val);
        }else{
            var nf = 1;
            $.each(post, function(k,v){
                var sp = v.split('_');
                var vv = sp[sp.length-1];
                sp = sp.splice(0, (sp.length-1));
                sp = sp.join('_');

                if(val == 0){
                    post.splice(k, 1);
                }else{
                    if(sp == slug){
                        post[k] = sp+'_'+val;
                    }
                }
            });
            if(nf == 1){ post.push(slug+'_'+val); }
        }
        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.sField',function(e){
        e.preventDefault();
        var val = $(this).attr('data-val');
        var slug = $(this).attr('data-field');
        if(field.length == 0){
            field.push(slug+'_'+val);
        }else{
            var nf = 1;
            $.each(field, function(k,v){
                console.log(v);
                var sp = v.split('_');
                var vv = sp[sp.length-1];
                sp = sp.splice(0, (sp.length-1));
                sp = sp.join('_');
                if(val == 0){
                    field.splice(k, 1);
                }else{
                    if(sp == slug){
                        if(val == vv){
                            field.splice(k, 1);
                        }else{
                            field[k] = sp+'_'+val;
                        }
                        nf = 0;
                    }
                }
            });
            if(nf == 1){ field.push(slug+'_'+val); }
        }

        page = 1;
        filterAds(page);
    });

    $(document).on('click', '.sRange',function(e){
        e.preventDefault();
        var slug = $(this).attr('data-range');
        var min = $(this).parents('.field_range_box').find('.min_v').val();
        var max = $(this).parents('.field_range_box').find('.max_v').val();
        if(min==null || min=='' || max==null || max==''){
            var val = null;
            if(range.length==0){
                return false;
            }
        }else{
            var val = min+'|'+max;
        }
        if(range.length == 0){
            range.push(slug+'_'+val);
        }else{
            var nf = 1;
            $.each(range, function(k,v){
                var sp = v.split('_');
                var vv = sp[sp.length-1];
                sp = sp.splice(0, (sp.length-1));
                sp = sp.join('_');
                if(val == 0){
                    range.splice(k, 1);
                }else{
                    if(sp == slug){
                        if(val == null){
                            range.splice(k, 1);
                        }else{
                            range[k] = sp+'_'+val;
                        }
                        nf = 0;
                    }
                }
            });
            if(nf == 1){ range.push(slug+'_'+val); }
        }
        page = 1;
        filterAds(page);
    });


    var counter = 3;
    function filterAds(page){
        $(document).ready(function(){
            $('.searching').fadeIn(100);
            if(category == '')
            { 
                category = 'categories'; 
            }else{
                category = 'categories/'+category;
            }
            var _url = category;
            var url = '';
            url += '?page='+page,
            url += (sort!==null && sort!=='')? '&sort='+sort : '',
            url += (country!==null && country!=='')? '&country='+country : '',
            url += (state!==null && state!=='')? '&state='+state : '',
            url += (city!==null && city!=='')? '&city='+city : '',
            url += (min!==null && min!=='')? '&min='+min : '',
            url += (max!==null && max!=='')? '&max='+max : '',
            url += (make!==null && make!=='')? '&make='+make : '',
            url += (makemodel!==null && makemodel!=='')? '&makemodel='+makemodel : '',
            url += (post!=null && post!='' && post.length>0)? '&post='+post.join(',') : '',
            url += (field!=null && field!='' && field.length>0)? '&field='+field.join(',') : '',
            url += (range!=null && range!='' && range.length>0)? '&range='+range.join(',') : '',
            window.history.pushState({path:url},'', '/'+_url+url);
            window.location.reload();
            // $.ajax({
            // url:_url+url,
            // type: 'GET',
            // cache: false,
            // async: true,
            // success: function(data){
            //     $('.list-render-html').html(data.html);
            //     $('.count-render-html').html(data.count);
            //     $('.sidebar-render-html').html(data.sidebar);
            //     $('.breadcrumbs-render-html').html(data.breadcrumbs);
            //     $('.searching').fadeOut(300);
            // },
            // error: function(error){
            //     counter--
            //     if(counter>0){
            //         filterAds(page);
            //     }
            // }
            // });
        });
    }

    function removeSingleCategory(url) {
        const urlObj = new URL(url);
        let pathSegments = urlObj.pathname.split('/');

        // Count occurrences of "categories"
        const categoriesCount = pathSegments.filter(segment => segment === 'categories').length;

        // Remove only if there are exactly two "categories"
        if (categoriesCount === 2) {
            const index = pathSegments.indexOf('categories');
            pathSegments.splice(index, 1); // Remove the first "categories"
        }

        // Rebuild the path
        urlObj.pathname = pathSegments.join('/');

        return urlObj.toString();
    }

    $(document).ready(function() {
        const newUrl = removeSingleCategory(window.location.href);
        window.history.pushState(null, '', newUrl);
    });
</script>

<script>
    $(document).on('click', '.addToList', function(){
        var _this = $(this);
        var id = $(this).attr('data-id');
        $.ajax({
            url: "{{url('addToList')}}",
            type: 'POST',
            data:{id:id, '_token':'{{csrf_token()}}'},
            success: function(res){
                if(res==1){
                    $(_this).parents('.addt').addClass('active');
                    $(_this).html('<img alt="" src="{{asset('assets_frontend/img/icon/svg/like.svg') }}" > Saved to List');
                }else{
                    $(_this).parents('.addt').removeClass('active');
                    $(_this).html('<img alt="" src="{{asset('assets_frontend/img/icon/svg/like.svg') }}" > Add To My List');
                }
            }
        })
    })
</script>
<script>
    let expanded = false;
    $("#expand-categories").click(function () {
        if (!expanded) {
            $("#side-categories .checkbox").show();
            $(this).text("Show Less");
        } else {
            $("#side-categories .checkbox").hide().slice(0, 5).show();
            $(this).text("Show More");
        }
        expanded = !expanded;
    });
</script>
@endsection