<div class="panel-group" id="filter-menu" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <a class="panel-title accordion-toggle" role="button" data-toggle="collapse" href="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                All Categories
            </a><!-- /.panel-title -->
        </div><!-- /.panel-heading -->
        <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                @if (isset($category))

                    <div class="checkbox">
                        <label class="sCategory" data-val="0" style="color:#2d2d2d;">All Categories</label>
                    </div>

                    @php $m = 0; @endphp
                    @foreach (array_reverse(onlyParents($category)) as $key => $value)
                        <div class="checkbox" style="margin-left:{{ $m }}px">
                            <label class="sCategory" data-val="{{ $value->slug }}">
                                <div>{{ $value->name }}</div>
                                <div class="ccount">({{ number_format(allChildCount($value)) }})</div>
                            </label>
                        </div>
                        @php $m += 20; @endphp
                    @endforeach

                    <div class="checkbox" style="margin-left:{{ $m }}px">
                        <label class="sCategory active" data-val="{{ generateUrl($category->id, 'category') }}" style="color:#1eaf38;">
                            <div>{{ $category->name }}</div>
                            <div class="ccount">({{ number_format(allChildCount($category)) }})</div>
                        </label>
                    </div>
                    @php $m += 20; @endphp

                    @foreach ($category->childrens as $key => $value)
                        <div class="checkbox" style="margin-left:{{ $m }}px">
                            <label class="sCategory" data-val="{{ generateUrl($value->id, 'category') }}">
                                <div>{{ $value->name }}</div>
                                <div class="ccount">({{ number_format(allChildCount($value)) }})</div>
                            </label>
                        </div>
                    @endforeach
                @else
                    @foreach (fetchCategories() as $key => $value)
                        <div class="checkbox">
                            <label class="sCategory" data-val="{{ generateUrl($value->id, 'category') }}">
                                <div>{{ $value->name }}</div>
                                <div class="ccount">({{ number_format(allChildCount($value)) }})</div>
                            </label>
                        </div>
                    @endforeach
                @endif
            </div><!-- /.panel-body -->
        </div><!-- /.panel-collapse -->
    </div><!-- /.panel -->

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <a class="panel-title accordion-toggle" role="button" data-toggle="collapse" href="#collapseTwo"
                aria-expanded="false" aria-controls="collapseTwo">
                Location
            </a><!-- /.panel-title -->

        </div><!-- /.panel-heading -->
        <div id="collapseTwo" class="panel-collapse collapse in show" role="tabpanel"
            aria-labelledby="headingTwo">
            <div class="panel-body">
                @foreach (getCountries() as $key => $value)
                    @php $m = 0; @endphp
                    <div class="checkbox">
                        <label class="sCountry @if (isset($_GET['country']) && $_GET['country'] == $value) active @endif"
                            data-val="{{ $value }}"
                            @if (isset($_GET['country']) && $_GET['country'] == $value) style="color:#1eaf38;" @endif>
                            <div>{{ $key }}</div>
                            <div class="ccount">({{ number_format(adsInLocation($value, 'country')) }})
                            </div>
                        </label>
                    </div>
                    @if (isset($_GET['country']) && $_GET['country'] == $value['country'])
                        @php $m += 20; @endphp
                        @foreach (getStatesByCountryName($_GET['country']) as $key => $value)
                            @if (isset($_GET['state']) && $_GET['state'] == $value['name'])
                                <div class="checkbox" style="margin-left:{{ $m }}px">
                                    <label class="sState @if (isset($_GET['state']) && $_GET['state'] == $value['name']) active @endif "
                                        data-val="{{ $value['name'] }}"
                                        @if (isset($_GET['state']) && $_GET['state'] == $value['name']) style="color:#1eaf38;" @endif>
                                        <div>{{ $value['name'] }}</div>
                                        <div class="ccount">
                                            ({{ number_format(adsInLocation($value['name'], 'state')) }})
                                        </div>
                                    </label>
                                </div>

                                @if (isset($_GET['state']) && $_GET['state'] == $value['name'])
                                    @php $m += 20; @endphp
                                    @foreach (getCitiesByStateName($_GET['state']) as $key => $value)
                                        @if (isset($_GET['city']) && $_GET['city'] == $value['name'])
                                            <div class="checkbox" style="margin-left:{{ $m }}px">
                                                <label
                                                    class="sCity @if (isset($_GET['city']) && $_GET['city'] == $value['name']) active @endif"
                                                    data-val="{{ $value['name'] }}"
                                                    @if (isset($_GET['city']) && $_GET['city'] == $value['name']) style="color:#1eaf38;" @endif>
                                                    <div>{{ $value['name'] }}</div>
                                                    <div class="ccount">
                                                        ({{ number_format(adsInLocation($value['name'], 'city')) }})
                                                    </div>
                                                </label>
                                            </div>
                                        @elseif(!isset($_GET['city']))
                                            <div class="checkbox" style="margin-left:{{ $m }}px">
                                                <label
                                                    class="sCity @if (isset($_GET['city']) && $_GET['city'] == $value['name']) active @endif"
                                                    data-val="{{ $value['name'] }}"
                                                    @if (isset($_GET['city']) && $_GET['city'] == $value['name']) style="color:#1eaf38;" @endif>
                                                    <div>{{ $value['name'] }}</div>
                                                    <div class="ccount">
                                                        ({{ number_format(adsInLocation($value['name'], 'city')) }})
                                                    </div>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @elseif(!isset($_GET['state']))
                                <div class="checkbox" style="margin-left:{{ $m }}px">
                                    <label class="sState @if (isset($_GET['state']) && $_GET['state'] == $value['name']) active @endif"
                                        data-val="{{ $value['name'] }}"
                                        @if (isset($_GET['state']) && $_GET['state'] == $value['name']) style="color:#1eaf38;" @endif>
                                        <div>{{ $value['name'] }}</div>
                                        <div class="ccount">
                                            ({{ number_format(adsInLocation($value['name'], 'state')) }})</div>
                                    </label>
                                </div>

                                @if (isset($_GET['state']) && $_GET['state'] == $value['name'])
                                    @php $m += 20; @endphp
                                    @foreach (getCitiesByStateName($_GET['state']) as $key => $value)
                                        @if (isset($_GET['city']) && $_GET['city'] == $value['name'])
                                            <div class="checkbox" style="margin-left:{{ $m }}px">
                                                <label
                                                    class="sCity @if (isset($_GET['city']) && $_GET['city'] == $value['name']) active @endif"
                                                    data-val="{{ $value['name'] }}"
                                                    @if (isset($_GET['city']) && $_GET['city'] == $value['name']) style="color:#1eaf38;" @endif>
                                                    <div>{{ $value['name'] }}</div>
                                                    <div class="ccount">
                                                        ({{ number_format(adsInLocation($value['name'], 'city')) }})
                                                    </div>
                                                </label>
                                            </div>
                                        @elseif(!isset($_GET['city']))
                                            <div class="checkbox" style="margin-left:{{ $m }}px">
                                                <label
                                                    class="sCity @if (isset($_GET['city']) && $_GET['city'] == $value['name']) active @endif "
                                                    data-val="{{ $value['name'] }}"
                                                    @if (isset($_GET['city']) && $_GET['city'] == $value['name']) style="color:#1eaf38;" @endif>
                                                    <div>{{ $value['name'] }}</div>
                                                    <div class="ccount">
                                                        ({{ number_format(adsInLocation($value['name'], 'city')) }})
                                                    </div>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div><!-- /.panel-body -->
        </div><!-- /.panel-collapse -->
    </div><!-- /.panel -->

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
            <a class="panel-title accordion-toggle" role="button" data-toggle="collapse" href="#collapseThree"
                aria-expanded="false" aria-controls="collapseThree">
                Price
            </a><!-- /.panel-title -->
        </div><!-- /.panel-heading -->
        <div id="collapseThree" class="panel-collapse collapse in show" role="tabpanel"
            aria-labelledby="headingThree">
            <div class="panel-body">
                <div class="inp">
                    <div class="m1">
                        <label>Min</label>
                        <input type="number" class="minValue" value="{{ $_GET['min'] ?? '' }}" />
                    </div>
                    <div class="m2">
                        <label>Max</label>
                        <input type="number" class="maxValue" value="{{ $_GET['max'] ?? '' }}" />
                    </div>
                    <div class="m3">
                        <button type="button" class="priceSearch">Apply</button>
                    </div>
                </div>
            </div><!-- /.panel-body -->
        </div><!-- /.panel-collapse -->
    </div><!-- /.panel -->

    @if (isset($category->fields) && count($category->fields) > 0)
        @foreach ($category->fields->sortBy('sort_order') as $key => $catefield)
            @php
                $field = $catefield->field;
                $show = 0;
                $end = null;
                $rend = null;
                if (isset($_GET['field']) && $_GET['field'] != null && $field != null) {
                    $fi = explode(',', $_GET['field']);
                    foreach ($fi as $f) {
                        $fe = explode('_', $f);
                        $end = $fe[count($fe) - 1];
                        unset($fe[count($fe) - 1]);
                        $fe = implode('_', $fe);
                        if (str_replace(' ', '_', $field->name) == $fe) {
                            $show = 1;
                            break;
                        }
                    }
                }
                if (isset($_GET['range']) && $_GET['range'] != null && $field != null) {
                    $fi = explode(',', $_GET['range']);
                    foreach ($fi as $f) {
                        $fe = explode('_', $f);
                        $rend = $fe[count($fe) - 1];
                        unset($fe[count($fe) - 1]);
                        $fe = implode('_', $fe);
                        if (str_replace(' ', '_', $field->name) == $fe) {
                            $show = 1;
                            break;
                        }
                    }
                }
            @endphp
            @if ($field != null && ($field->type == 'select' || $field->type == 'number'))
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour_{{ $key }}">
                        <a class="panel-title accordion-toggle @if ($show == 1) @else collapsed @endif "
                            role="button" data-toggle="collapse" href="#collapseFour_{{ $key }}"
                            aria-expanded="false" aria-controls="collapseFour_{{ $key }}">
                            {{ $catefield->title ?? $field->name }}
                        </a>
                    </div>

                    <div id="collapseFour_{{ $key }}"
                        class="panel-collapse collapse @if ($show == 1) in show @else @endif "
                        role="tabpanel" aria-labelledby="headingFour_{{ $key }}">
                        <div class="panel-body">

                            @if ($field->type == 'select' && $field->data != null && isset($field->data['options']))
                                @php $options = explode(',', $field->data['options']); @endphp
                                @foreach ($options as $key => $opt)
                                    <div class="checkbox field_check1">
                                        <label
                                            class="sField_label sField @if ($end == $opt) active @endif"
                                            data-field="{{ str_replace(' ', '_', $field->name) }}"
                                            data-val="{{ $opt }}"
                                            @if ($end == $opt) style="background-color:#1eaf38;color:white;border:solid 1px #1eaf38" @endif>
                                            {{ ucfirst($opt) }}
                                        </label>
                                    </div>
                                @endforeach
                            @elseif($field->type == 'number')
                                <div class="inp field_range_box">
                                    <div class="m1">
                                        <label>Min {{ $catefield->title ?? $field->name }}</label>
                                        <input type="number" class="min_v"
                                            @if ($rend != null && $show == 1) value="{{ explode('|', $rend)[0] }}" @endif />
                                    </div>
                                    <div class="m2">
                                        <label>Max {{ $catefield->title ?? $field->name }}</label>
                                        <input type="number" class="max_v"
                                            @if ($rend != null && $show == 1) value="{{ explode('|', $rend)[1] }}" @endif />
                                    </div>
                                    <div class="m3">
                                        <button type="button" class="sRange"
                                            data-range="{{ str_replace(' ', '_', $field->name) }}">Apply</button>
                                    </div>
                                </div>
                            @endif



                        </div>
                    </div>
                </div>
            @elseif($field != null && $field->type == 'multiselect')
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour_{{ $key }}">
                        <a class="panel-title accordion-toggle @if ($show == 1) @else collapsed @endif "
                            role="button" data-toggle="collapse" href="#collapseFour_{{ $key }}"
                            aria-expanded="false" aria-controls="collapseFour_{{ $key }}">
                            {{ $catefield->title ?? $field->name }}
                        </a>
                    </div>

                    <div id="collapseFour_{{ $key }}"
                        class="panel-collapse collapse @if ($show == 1) in show @else @endif "
                        role="tabpanel" aria-labelledby="headingFour_{{ $key }}">
                        <div class="panel-body">
                            @if ($field->type == 'multiselect' && $field->data != null && isset($field->data['options']))
                                @php $options = explode(',', $field->data['options']); @endphp
                                @foreach ($options as $key => $opt)
                                    <div class="checkbox field_check1">
                                        <label
                                            class="sField_label sField @if ($end == $opt) active @endif"
                                            data-field="{{ str_replace(' ', '_', $field->name) }}"
                                            data-val="{{ $opt }}"
                                            @if ($end == $opt) style="background-color:#1eaf38;color:white;border:solid 1px #1eaf38" @endif>
                                            {{ ucfirst($opt) }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($catefield->module == 'make')
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFourModule_{{ $key }}">
                        <a class="panel-title accordion-toggle" role="button" data-toggle="collapse"
                            href="#collapseFourModule_{{ $key }}" aria-expanded="false"
                            aria-controls="collapseFourModule_{{ $key }}">
                            Car Make
                        </a>
                    </div>

                    <div id="collapseFourModule_{{ $key }}" class="panel-collapse collapse in show "
                        role="tabpanel" aria-labelledby="headingFourModule_{{ $key }}">
                        <div class="panel-body carmks">

                            <div class="checkbox">
                                <label class="sMake" data-val="0" style="color:#2d2d2d;">All Makes</label>
                            </div>

                            @foreach (getMakes() as $key => $value)
                                @php $m = 0; @endphp

                                @if (isset($_GET['make']) && $_GET['make'] == $value->id)
                                    <div class="checkbox" style="margin-left:{{ $m }}px">
                                        <label class="sMake @if (isset($_GET['make']) && $_GET['make'] == $value->id) active @endif"
                                            data-val="{{ $value->id }}"
                                            @if (isset($_GET['make']) && $_GET['make'] == $value->id) style="color:#1eaf38;" @endif>
                                            <div><img
                                                    src="{{ url($value->image != null ? getThumb($value->image) : '#') }}" alt="{{($value->name)??''}}"></div>
                                            <div>{{ $value->name }}</div>
                                        </label>
                                    </div>

                                    @if (count($value->make_model) > 0)
                                        @php $m += 40; @endphp
                                        @if (isset($_GET['makemodel']))
                                            @php
                                                $model = $value->make_model->where('id', $_GET['makemodel']);
                                                $model = $model->first();
                                            @endphp
                                            <div class="checkbox" style="margin-left:{{ $m }}px">
                                                <label class="sMakeModel active" data-val="{{ $model->id }}"
                                                    style="color:#1eaf38;">
                                                    <div>{{ $model->name }}</div>
                                                </label>
                                            </div>
                                        @else
                                            @foreach ($value->make_model as $key => $value)
                                                <div class="checkbox" style="margin-left:{{ $m }}px">
                                                    <label class="sMakeModel" data-val="{{ $value->id }}">
                                                        <div>{{ $value->name }}</div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                @elseif(!isset($_GET['make']))
                                    <div class="checkbox" style="margin-left:{{ $m }}px">
                                        <label class="sMake @if (isset($_GET['make']) && $_GET['make'] == $value->id) active @endif"
                                            data-val="{{ $value->id }}"
                                            @if (isset($_GET['make']) && $_GET['make'] == $value->id) style="color:#1eaf38;" @endif>
                                            <div><img
                                                    src="{{ url($value->image != null ? getThumb($value->image) : '#') }}"
                                                    alt=""></div>
                                            <div>{{ $value->name }}</div>
                                        </label>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                </div>
            @elseif($catefield->post_id != null)
                @php $posts = getPostByPostTypeId($catefield->post_id, $category->id); @endphp
                @if (count($posts) > 0)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFourModule_{{ $key }}">
                            <a class="panel-title accordion-toggle" role="button" data-toggle="collapse"
                                href="#collapseFourModule_{{ $key }}" aria-expanded="false"
                                aria-controls="collapseFourModule_{{ $key }}">
                                {{ ucfirst(str_replace('_', ' ', $catefield->module)) }}
                            </a>
                        </div>

                        <div id="collapseFourModule_{{ $key }}"
                            class="panel-collapse collapse in show " role="tabpanel"
                            aria-labelledby="headingFourModule_{{ $key }}">
                            <div class="panel-body">

                                <div class="checkbox">
                                    <label class="sPost" data-val="0" data-post="{{ $catefield->module }}"
                                        style="color:#2d2d2d;">All
                                        {{ ucfirst(str_replace('_', ' ', $catefield->module)) }}</label>
                                </div>

                                @foreach ($posts as $key => $value)
                                    @php $m = 0; @endphp

                                    @if (isset($_GET['post']) && in_array($catefield->module . '_' . $value->id, explode(',', $_GET['post'])))
                                        <div class="checkbox" style="margin-left:{{ $m }}px">
                                            <label data-val="{{ $value->id }}"
                                                data-post="{{ $catefield->module }}"
                                                @if (isset($_GET['post']) && in_array($catefield->module . '_' . $value->id, explode(',', $_GET['post']))) style="color:#1eaf38;" class="sPost active"  @else class="sPost" @endif>
                                                @if ($value->image != null)
                                                    <div><img
                                                            src="{{ url($value->image != null ? getThumb($value->image) : '#') }}"
                                                            alt=""></div>
                                                @endif
                                                <div>{{ $value->title }}</div>
                                            </label>
                                        </div>
                                    @elseif(!isset($_GET['post']))
                                        <div class="checkbox" style="margin-left:{{ $m }}px">
                                            <label data-val="{{ $value->id }}"
                                                data-post="{{ $catefield->module }}"
                                                @if (isset($_GET['post']) && in_array($catefield->module . '_' . $value->id, explode(',', $_GET['post']))) style="color:#1eaf38;" class="sPost active"  @else class="sPost" @endif>
                                                @if ($value->image != null)
                                                    <div><img
                                                            src="{{ url($value->image != null ? getThumb($value->image) : '#') }}"
                                                            alt=""></div>
                                                @endif
                                                <div>{{ $value->title }}</div>
                                            </label>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    @endif
</div>
