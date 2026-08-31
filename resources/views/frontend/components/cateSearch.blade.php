@php $rand = rand(00000, 99999); @endphp
<section @if(isset($meta['sub'])) class="flats" @else class="notabs" @endif>
    <div class="container">
        <div class="row">
            @if(isset($meta['sub']) && isset($meta['sub_categories']))
            @php
                $parent_category = getCategory($meta['category']);
                $childrens = $parent_category->childrens->whereNotIn('id', $meta['sub_categories']);
            @endphp
            <div class="col-sm-12">
                <ul class="nav nav-tabs mobiletabs">
                    @foreach (categoriesById($meta['sub_categories']) as $k=>$cate)
					<li><a @if($k == 0) class="active" @endif data-toggle="tab" href="#category_{{$k}}">{{$cate->name}}</a></li>
                    @endforeach
                    @if(count($childrens) > 0)
					<li><a data-toggle="tab" href="#category_all_{{$rand}}">More</a></li>
                    @endif
				</ul>

				<div class="tab-content mbcat">
                    @foreach (categoriesById($meta['sub_categories']) as $k => $category)
					<div id="category_{{$k}}" class="tab-pane fade @if($k == 0) active show @endif ">
						<h3>{{$category->name}}</h3>
						<div class="formProperty">
							<form action="{{url(generateUrl($category->id, 'category'))}}" method="GET">
                                <div class="formnotTabs">
                                    @foreach($category->fields as $catfield)
                                        @php $field = $catfield->field; @endphp
                                        @if($catfield->module == 'make')

                                            <div class="i-div">
                                                <select name="make" class="form-control us-select-hide fetchMakeModels_{{$key}}">
                                                    <option value="" disabled selected data-placeholder="Select the Make">Select the Make</option>
                                                    <option value="">All</option>
                                                    @foreach(getMakes() as $make)
                                                    <option value="{{$make->id}}">{{$make->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        @elseif($catfield->module == 'model')

                                            <div class="i-div">
                                                <select name="makemodel" class="form-control us-select-hide makeModels_{{$key}}">
                                                    <option value="" disabled selected data-placeholder="Select the Make Model">Select the Make Model</option>
                                                    <option value="">All</option>

                                                </select>
                                            </div>

                                        @elseif($catfield->post_id != null)
                                            @php
                                                $module = str_replace('_', ' ', $catfield->module);
                                                $posts = getPostByPostTypeId($catfield->post_id, $category->id);
                                            @endphp
                                            @if(count($posts) > 0)
                                            <div class="i-div">
                                                <select name="post[]" class="form-control us-select-hide">
                                                    <option value="" disabled selected data-placeholder="Select the {{$module}}">Select the {{ucfirst($module)}}</option>
                                                    <option value="">All</option>
                                                    @foreach($posts as $post)
                                                    <option value="{{$catfield->module.'_'.$post->id}}">{{$post->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                        @else
                                            @if(isset($field))
                                                @if($field->type == 'select')
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
                                                        <select name="field[]" class="us-select-hide form-control">
                                                            <option value="" data-placeholder="Select the {{$field->name}}">Select the {{$field->name}}</option>
                                                            <option value="">All</option>
                                                            @foreach($opt as $op)
                                                                <option value="{{$fname.'_'.$op}}">{{$op}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @elseif($field->type == 'multiselect')
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
                                                    <div class="i-div select_picker">
                                                        <div data-toggle="dropdown" class="dropdown-toggle select_div btn btn-default">
                                                            Select the {{$field->name}}
                                                        </div>
                                                        <ul class="dropdown-menu">
                                                            @foreach($opt as $op)
                                                                <li>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" name="field[]" value="{{$fname.'_'.$op}}">{{$op}}
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
                                                        <input type="number" name="range[]" data-name="{{ $fname }}" data-n="min" class="form-control" placeholder="Min {{$field->name}}">
                                                    </div>

                                                    <div class="s-div">
                                                        <input type="number" name="range[]" data-name="{{ $fname }}" data-n="max" class="form-control" placeholder="Max {{$field->name}}">
                                                    </div>
                                                @endif
                                            @endif
                                            {{-- {{dd($catfield->field)}} --}}
                                        @endif
                                    @endforeach
                                    <div class="i-div">
                                        <button type="button" class="catSearchMakeUrl">Search</button>
                                    </div>
                                </div>
                            </form>
						</div>
					</div>
                    @endforeach
                    @if(count($childrens) > 0)
                    <div id="category_all_{{$rand}}" class="tab-pane fade">
                        @php $category = $childrens->first(); @endphp
                        @include('frontend.includes.category_fields', ['page'=>1, 'category'=>$category])
					</div>
                    @endif
				</div>
			</div>
            @else
            <div class="col-sm-12">
                <div class="contentDv">
                    @if(isset($meta['title'])) <h3>{{$meta['title']}}</h3> @endif
                    @if(isset($meta['category']))
                        @php $category = getCategory($meta['category']); @endphp
                        <div class="formProperty">
                            <form action="{{url(generateUrl($category->id, 'category'))}}" method="GET">
                                <div class="formnotTabs">
                                    @foreach($category->fields as $catfield)
                                        @php $field = $catfield->field; @endphp
                                        @if($catfield->module == 'make')

                                            <div class="i-div">
                                                <select name="make" class="form-control us-select-hide fetchMakeModels_{{$key}}">
                                                    <option value="" disabled selected data-placeholder="Select the Make">Select the Make</option>
                                                    <option value="">All</option>
                                                    @foreach(getMakes() as $make)
                                                    <option value="{{$make->id}}">{{$make->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        @elseif($catfield->module == 'model')

                                            <div class="i-div">
                                                <select name="makemodel" class="form-control us-select-hide makeModels_{{$key}}">
                                                    <option value="" disabled selected data-placeholder="Select the Make Model">Select the Make Model</option>
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
                                                    <option value="" disabled selected data-placeholder="Select the {{$module}}">Select the {{$module}}</option>
                                                    <option value="">All</option>
                                                    @foreach($posts as $post)
                                                    <option value="{{$catfield->module.'_'.$post->id}}">{{$post->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            @if(isset($field))
                                                @if($field->type == 'select')
                                                    @php
                                                        $fname = str_replace(' ', '_', $field->name);
                                                        $opt = (isset($field->data['options']))?explode(',', $field->data['options']):[];
                                                    @endphp
                                                    <div class="i-div">
                                                        <select name="field[]" class="us-select-hide form-control">
                                                            <option value="" data-placeholder="Enter the {{$field->name}}">Enter the {{$field->name}}</option>
                                                            <option value="">All</option>
                                                            @foreach($opt as $op)
                                                                <option value="{{$fname.'_'.$op}}">{{$op}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @elseif($field->type == 'multiselect')
                                                    @php
                                                        $fname = str_replace(' ', '_', $field->name);
                                                        $opt = (isset($field->data['options']))?explode(',', $field->data['options']):[];
                                                    @endphp
                                                    <div class="i-div select_picker">
                                                        <div data-toggle="dropdown" class="dropdown-toggle select_div btn btn-default">
                                                            Enter the {{$field->name}}
                                                        </div>
                                                        <ul class="dropdown-menu">
                                                            @foreach($opt as $op)
                                                                <li>
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" name="field[]" value="{{$fname.'_'.$op}}">{{$op}}
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    {{-- <div class="i-div">
                                                        <select name="field[]" class="us-select-hide form-control select_2"  multiple>
                                                            <option value="" data-placeholder="Enter the {{$field->name}}">Enter the {{$field->name}}</option>
                                                            <option value="">All</option>
                                                            @foreach($opt as $op)
                                                                <option value="{{$fname.'_'.$op}}">{{$op}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> --}}
                                                @elseif($field->type == 'number')
                                                    @php
                                                        $fname = str_replace(' ', '_', $field->name);
                                                    @endphp
                                                    <div class="s-div">
                                                        <input type="number" name="range[]" data-name="{{ $fname }}" data-n="min" class="form-control" placeholder="Min {{$field->name}}">
                                                    </div>

                                                    <div class="s-div">
                                                        <input type="number" name="range[]" data-name="{{ $fname }}" data-n="max" class="form-control" placeholder="Max {{$field->name}}">
                                                    </div>
                                                @endif
                                            @endif
                                            {{-- {{dd($catfield->field)}} --}}
                                        @endif
                                    @endforeach
                                    <div class="i-div">
                                        <button type="button" class="catSearchMakeUrl">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@push('push_script')
    <script>
        $(document).on('change', '.fetchMakeModels_{{$key}}', function() {
            var id = $(this).val();
            var data = {
                _token: '{{ csrf_token() }}',
                id: id,
                start: `<option value="" disabled selected data-placeholder="Select the Make Model">Select the Make Model</option><option value="">All</option>`,
            };
            if (id != null && id != '') {
                $.ajax({
                    url: '{{ route('fetchMakeModels') }}',
                    type: 'POST',
                    data: data,
                    success: function(res) {
                        $('.makeModels_{{$key}}').html(res.models);
                    }
                })
            } else {
                $('.makeModels_{{$key}}').html('');
            }
        });

        @if(isset($meta['sub']) && isset($meta['sub_categories']))
        $(document).on('change', '.category_action', function(){
            var id = $(this).val();
            var data = {'_token':'{{csrf_token()}}', id:id, 'category_search':1, sub: '{!! json_encode($meta['sub_categories']) !!}'};
            $.ajax({
                url: '{{ route('fetchCategory') }}',
                type: 'POST',
                data: data,
                success: function(res) {
                    $('#category_all_'+'{{$rand}}').html(res);
                }
            })
        });
        @endif
    </script>
@endpush
