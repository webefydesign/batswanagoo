<div class="searching"></div>
    <div class="overlay-filtermobile"></div>
    <section class="all-list-bre brd-1" >
        <div class="container sec-all-list-bre">
            <div class="row breadcrumbs-render-html">
                <ul>
                    <li> <a href="{{ url('/') }}">Back to Home</a> </li>
                    @if (isset($_GET['country']))
                        <li> <a href="{{ url('categories?page=1&country=' . $_GET['country']) }}" class="changePara"
                                data-para="country" data-val="{{ $_GET['country'] }}">{{ $_GET['country'] }}</a> </li>
                    @endif
                    @if (isset($_GET['state']))
                        <li> <a href="{{ url('categories?page=1&country=' . $_GET['country'] . '&state=' . $_GET['state']) }}"
                                class="changePara" data-para="state" data-val="{{ $_GET['state'] }}">{{ $_GET['state'] }}</a>
                        </li>
                    @endif
                    @if (isset($_GET['city']))
                        <li> <a href="{{ url('categories?page=1&country=' . $_GET['country'] . '&state=' . $_GET['state'] . '&city=' . $_GET['city']) }}"
                                class="changePara" data-para="city" data-val="{{ $_GET['city'] }}">{{ $_GET['city'] }}</a> </li>
                    @endif
                    @foreach ($all_parent_categories as $cate)
                        <li><a href="{{ url($cate->slug) }}" class="changePara" data-para="category"
                                data-val="{{ $cate->id }}">{{ $cate->name }}</a> </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <section style="position:relative;" class="mb-f">
        <div class="search-filters-panel-mobile-aa ani" style="display:none"></div>
        <div class="all-listing all-listing-pg for-counting" @if(isset($general_meta['search']['bg'])) style="background:url('{{url(($general_meta['search']['bg'])??'#')}}') no-repeat #5085f7;background-size:cover;background-attachment: fixed;" @endif>

            <!--FILTER ON MOBILE VIEW-->
            <div class="fil-mob fil-mob-act">
                <h4>Listing filters <i class="material-icons">filter_list</i></h4>
            </div>
            <div class="all-list-bre">
                <div class="container sec-all-list-bre">
                    <div class="row count-render-html countingbg">
                        @if (isset($all_parent_categories) && isset($category))
                            <h1>{{ allChildCount($category) }} Ads <small>in
                                    {{ $all_parent_categories[count($all_parent_categories) - 1]['name'] ?? 'Batswana Goo' }}</small></h1>
                            <a href="javascript:;" class="btn-show-filters-aa"></a>
                        @else
                            <h1>{{ $ads->total() }} Ads <small>in Batswana Goo</small></h1>
                        @endif
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 fil-mob-view">
                        <div class="filter-menu">
                            <div class="panel panel-default">
                                <div class="panel-heading filterdesktoppanel">
                                    <div class="panel-body">
                                        <div class="mobilefle">
                                            <div class="fle">
                                                <button class="btn btn-default filter resetbt" type="button">Apply Filters</button>
                                                <a class="btn btn-sm btn-link clears pull-right visible-sm-inline donbt" href="javascript:void(0);">Clear</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body sidebar-render-html">
                                    @include('frontend.includes.search_sidebar')
                                </div>
                            </div>
                            <div class="panel-heading filterMobilediv">
                                <div class="panel-body">
                                    <div class="mobilefle">
                                        <div class="fle">
                                            <button class="btn btn-default filter resetbt mbt-apply" type="button">Apply Filters</button>
                                            <a class="btn btn-sm btn-link clears pull-right visible-sm-inline donbt"
                                                href="javascript:void(0);">Clear</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="f2">
                            <div class="vfilter"> <i class="material-icons ic1 " title="Grid view">apps</i>
                                <i class="material-icons ic2 act" title="List view">format_list_bulleted</i>
                                <i class="material-icons ic3" title="Map view">location_on</i>
                            </div>
                        </div>
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
                        @if(isset($general_meta['search']['adv_image_1']))
                            <div class="ban-ati-com ads-all-list">
                                <a href="{{url(($general_meta['search']['adv_link_1'])??'#')}}"><span>Ad</span><img src="{{url(($general_meta['search']['adv_image_1'])??'#')}}" alt="">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>
