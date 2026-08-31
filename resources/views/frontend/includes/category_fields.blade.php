@if (isset($page) && $page == 1)
    <h3>More {{ $category->name }}</h3>
    <div class="formProperty">
        <form action="{{ url($category['slug'] ?? '#') }}" method="GET">
            <div class="formnotTabs">
                <div class="i-div">
                    <select class="category_action us-select-hide form-control">
                        @foreach ($childrens as $cate)
                            <option value="{{ $cate->id }}" @if ($category->id == $cate->id) selected @endif>
                                {{ $cate->name }}</option>
                        @endforeach
                    </select>
                </div>
                @foreach ($category->fields as $catfield)
                    @php $field = $catfield->field; @endphp
                    @if ($catfield->module == 'make')
                        <div class="i-div">
                            <select name="make"
                                class="form-control us-select-hide fetchMakeModels_{{ $key }}">
                                <option value="" disabled selected data-placeholder="Select the Make">Select the
                                    Make</option>
                                <option value="">All</option>
                                @foreach (getMakes() as $make)
                                    <option value="{{ $make->id }}">{{ $make->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($catfield->module == 'model')
                        <div class="i-div">
                            <select name="makemodel" class="form-control us-select-hide makeModels_{{ $key }}">
                                <option value="" disabled selected data-placeholder="Select the Make Model">Select
                                    the Make Model</option>
                                <option value="">All</option>

                            </select>
                        </div>
                    @elseif($catfield->post_id != null)
                        @php
                            $module = str_replace('_', ' ', $catfield->module);
                            $posts = getPostByPostTypeId($catfield->post_id, $category->id);
                        @endphp
                        <div class="i-div">
                            <select name="post[]" class="form-control us-select-hide">
                                <option value="" disabled selected
                                    data-placeholder="Select the {{ $module }}">Select the {{ $module }}
                                </option>
                                <option value="">All</option>
                                @foreach ($posts as $post)
                                    <option value="{{ $catfield->module . '_' . $post->id }}">{{ $post->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        @if(isset($field))
                            @if ($field->type == 'select')
                                @php
                                    $fname = str_replace(' ', '_', $field->name);
                                    $opt = [];
                                    if (isset($field->data['options'])) {
                                        if (is_array($field->data['options'])) {
                                            $opt = $field->data['options'];
                                        } else {
                                            $opt = explode(',', $field->data['options']);
                                        }
                                    }
                                @endphp
                                <div class="i-div">
                                    <select name="field[]" class="us-select-hide select_2 form-control">
                                        <option value="" data-placeholder="Enter the {{ $field->name }}">Enter the
                                            {{ $field->name }}</option>
                                        <option value="">All</option>
                                        @foreach ($opt as $op)
                                            <option value="{{ $fname . '_' . $op }}">{{ $op }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif($field->type == 'multiselect')
                                <div class="i-div select_picker">
                                    <div data-toggle="dropdown" class="dropdown-toggle select_div fff btn btn-default">
                                        Enter the {{ $field->name }}
                                    </div>
                                    <ul class="dropdown-menu">
                                        @foreach ($opt as $op)
                                            <li>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="field[]"
                                                            value="{{ $fname . '_' . $op }}">{{ $op }}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @elseif($field->type == 'number')
                                @php
                                    $fname = str_replace(' ', '_', $field->name);
                                @endphp
                                <div class="s-div">
                                    <input type="number" name="range[]" data-name="{{ $fname }}" data-n="min"
                                        class="form-control"
                                        placeholder="Min {{ $field->name }}">
                                </div>

                                <div class="s-div">
                                    <input type="number" name="range[]" data-name="{{ $fname }}" data-n="max"
                                        class="form-control"
                                        placeholder="Max {{ $field->name }}">
                                </div>
                            @endif
                        @endif
                    @endif
                @endforeach
                <div class="i-div">
                    <button type="button" class="catSearchMakeUrl">Search</button>
                </div>
            </div>
        </form>
    </div>
@else
    <div class="row">
        @foreach ($category->fields->sortBy('sort_order') as $k => $field)
            @if ($field->field_id != null && $field->field_id != 0 && $field->field != null)
                <div class="form-group col-sm-{{ $field->col ?? 12 }}">
                    @php
                        $title = $field->field->name ?? null;
                        $title = $field->title ?? $title;
                    @endphp
                    <div class="labelTxt">
                        <label>{{ $title }}</label>
                        @if ($field->is_required == 1)
                            <span>(Required)</span>
                        @else
                            <span>(Optional)</span>
                        @endif
                    </div>
                    @if ($field->field->type == 'select')
                        <select class="form-control select_2" name="field[{{ $title }}]"
                            @if ($field->is_required == 1) required @endif>
                            <option value="" selected="" disabled>Select</option>
                            @if (isset($field->field->data['options']))
                                @php
                                    $rawOptions = $field->field->data['options'];
                            
                                    // Normalize to array
                                    if (is_array($rawOptions)) {
                                        $options = $rawOptions;
                                    } else {
                                        $options = explode(',', $rawOptions);
                                    }
                                @endphp
                            
                                @foreach ($options as $opt)
                                    <option value="{{ $opt }}"
                                        @if (isset($adv[$title]) && $adv[$title] == $opt) selected @endif>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    @elseif($field->field->type == 'multiselect')
                        @php
                            $adv_title = [];
                    
                            if (isset($adv[$title])) {
                                $decoded = json_decode($adv[$title], true);
                                $adv_title = is_array($decoded) ? $decoded : [];
                            }
                    
                            // Normalize options to array
                            $options = [];
                            if (isset($field->field->data['options'])) {
                                if (is_array($field->field->data['options'])) {
                                    $options = $field->field->data['options'];
                                } else {
                                    $options = explode(',', $field->field->data['options']);
                                }
                            }
                        @endphp
                    
                        <div class="form-group">
                            <label style="display:none;">
                                {{ implode(', ', $adv_title) }}
                            </label>
                    
                            @if(count($options))
                                <select class="form-control select_div select_2"
                                        name="field[{{ $title }}][]"
                                        multiple="multiple">
                                    @foreach ($options as $opt)
                                        <option value="{{ $opt }}"
                                            @if(in_array($opt, $adv_title)) selected @endif>
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    @elseif($field->field->type == 'textarea')
                        <textarea type="{{ $field->field->type }}" style="position: initial;" name="field[{{ $title }}]"
                            class="form-control" @if ($field->is_required == 1) required @endif
                            @if ($field->field->placeholder != null) placeholder="{{ $field->field->placeholder }}" @endif rows="4">
                            @if (isset($title)) {{ $adv[$title] ?? null }}  @endif
                        </textarea>
                    @elseif($field->field->type == 'checkbox')
                        <label class="switch-c">
                            <input type="checkbox" name="field[{{ $title }}]" class="publish-ad" value="1"
                                @if (isset($adv[$title])) checked @endif>
                            <span class="slider-c round"></span>
                        </label>
                    @else
                        <input type="{{ $field->field->type }}" name="field[{{ $title }}]"
                            class="form-control @if($field->field->type!='date') @endif " @if($field->field->type != 'date') @endif
                            @if ($field->is_required == 1) required @endif
                            @if ($field->field->placeholder != null) placeholder="{{ $field->field->placeholder }}" @endif
                            @if (isset($title)) value="{{ $adv[$title] ?? null }}" @endif>
                    @endif

                </div>
            @else
                <div class="form-group col-sm-{{ $field->col ?? 12 }}">
                    @php $name = ucfirst(str_replace('_', ' ', $field->module)); @endphp
                    <div class="labelTxt">
                        <label style="text-transform: capitalize;">{{ $name }}</label>
                        @if ($field->is_required == 1)
                            <span>(Required)</span>
                        @else
                            <span>(Optional)</span>
                        @endif
                    </div>
                    @if ($field->module == 'make')
                        <select class="form-control fetchMakeModels" name="field[{{ $name }}]"
                            @if ($field->is_required == 1) required @endif>
                            <option value="" selected="">Select</option>
                            @foreach (getMakes() as $make)
                                <option value="{{ $make->name }}" @if (isset($adv[$name ?? '']) && $adv[$name ?? ''] == $make->name) selected @endif
                                    data-id="{{ $make->id }}">{{ $make->name }}</option>
                            @endforeach
                        </select>
                    @elseif($field->module == 'model')
                        <select class="form-control makeModels" name="field[{{ $name }}]"
                            @if ($field->is_required == 1) required @endif>
                            <option value="" selected="">Select</option>
                            @if (isset($adv['Make']))
                                @foreach (getModels($adv['Make']) as $model)
                                    <option value="{{ $model->name }}"
                                        @if (isset($adv[$name ?? '']) && $adv[$name ?? ''] == $model->name) selected @endif
                                        data-id="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    @elseif($field->post_id != null)
                        <select class="form-control" name="field[{{ $name }}]"
                            @if ($field->is_required == 1) required @endif>
                            <option value="" selected="">Select</option>
                            @foreach (getPostByPostTypeId($field->post_id, $category->id) as $post)
                                <option value="{{ $post->title }}"
                                    @if (isset($adv[$name ?? '']) && $adv[$name ?? ''] == $post->title) selected @endif>{{ $post->title }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endif
        @endforeach

    </div>
@endif