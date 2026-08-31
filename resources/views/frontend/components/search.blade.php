<section>
    <div class="all-jobs-ban">
        <div class="container">
            <div class="row">
                <div class="jtit">
                    <h1>{{($meta['title'])??''}}</h1>
                    <p>{{($meta['text'])??''}}</p>
                </div>
                <br>
                <div class="job-sear">
                    <form action="{{url('categories')}}" method="GET" name="job_filter_form" id="job_filter_form" class="job_filter_form">
                        <ul>
                            <li class="sr-sea">
                                <select class="chosen-select" id="bcat-select-search" name="category">
                                    <option value="">Search All Category</option>
                                    @if(isset($meta['category']) && count($meta['category'])>0)
                                        @foreach (categoriesById($meta['category']) as $cate)
                                            <option value="{{$cate->id}}" data-url="{{$cate->slug}}">{{$cate->name}}</option>
                                        @endforeach
                                    @else
                                        @foreach (parentCategories() as $cate)
                                            <option value="{{$cate->id}}" data-url="{{$cate->slug}}">{{$cate->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </li>
                            <li class="sr-loc">
                                @if(isset($meta['place_type']) && $meta['place_type'] == 'countries')
                                    <select class="chosen-select" id="job-select-city" name="country">
                                        <option value="">All Countries</option>
                                        @foreach (getCountries() as $k => $country)
                                            <option value="{{$country}}" @if(isset($meta['country']) && $meta['country']==$country) selected @endif >{{$k}}</option>
                                        @endforeach
                                    </select>
                                @elseif(isset($meta['place_type']) && $meta['place_type'] == 'states' && isset($meta['country']))
                                    <input type="hidden" name="country" value="{{$meta['country']}}">
                                    <select class="chosen-select" id="job-select-city" name="state">
                                        <option value="">All states of {{(fetchCountryName($meta['country']))??''}}</option>
                                        @foreach (getStates(($meta['country'])??null) as $s => $state)
                                            <option value="{{$state}}">{{$s}}</option>
                                        @endforeach
                                    </select>
                                @elseif(isset($meta['place_type']) && $meta['place_type'] == 'cities' && isset($meta['country']))
                                    <input type="hidden" name="country" value="{{$meta['country']}}">
                                    <select class="chosen-select" id="job-select-city" name="city">
                                        <option value="">All cities of {{(fetchCountryName($meta['country']))??''}}</option>
                                        @foreach (getCities(($meta['country'])??null) as $c => $city)
                                            <option value="{{$city}}">{{$c}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select class="chosen-select" id="job-select-city" name="country">
                                        <option value="">All Countries</option>
                                        @foreach (getCountries() as $country)
                                            <option value="{{$country}}">{{$k}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </li>
                            <li class="sr-btn">
                                <button id="" type="submit"><i class="material-icons">search</i></button>
                            </li>
                        </ul>
                    </form>
                </div>
                <div class="ban-short-links">
                    <div class="v3-list-ql-inn">
                        <ul>
                            @foreach(categories(null, null, 1) as $category)
                                {{-- @php $cateslug = ($category->page->slug)??$category->getSlug($category->slug); @endphp --}}
                                <li>
                                    <div>
                                        <img src="{{url(($category->icon_image)??'#')}}" alt="{{$category->name}}">
                                        <h4>{{$category->name}}</h4>
                                        <a href="{{url(generateUrl($category->id, 'page'))}}" class="fclick"></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
