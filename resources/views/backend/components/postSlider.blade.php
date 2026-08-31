<div class="comp-item postSlider_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="postSlider_{{$rand}}" style="background: url({{asset('components/postSlider.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][postSlider][eye]" class="postSlider_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="postSlider_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_postSlider_{{$rand}}" style="display: none;">
        <div class="row">

            <div class="col-md-6 form-group pb-2">
                <label for="heading{{$rand}}">Heading</label>
                <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][postSlider][title]" value="{{$meta['title']??''}}" id="heading{{$rand}}">
            </div>

            <div class="col-md-6 form-group pb-2">
                <label for="text{{$rand}}">Text</label>
                <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][postSlider][text]" value="{{$meta['text']??''}}" id="text{{$rand}}">
            </div>

            <div class="col-md-6">
                <div class="form-group pb-2">
                    <label for="type{{$rand}}">Listing Type</label>
                    <select name="components[{{$rand}}][postSlider][type]" class="form-control input-sm select2 isCateT" id="type{{$rand}}" data-rand="{{$rand}}">
                        <option value="" disabled selected style="display:none">Choose Any</option>
                        <option value="make" @if(isset($meta['type']) && $meta['type'] == 'make') selected @endif>Make</option>
                        <option value="makeModel" @if(isset($meta['type']) && $meta['type'] == 'makeModel') selected @endif>Make Model</option>
                        {{-- <option value="faqs" @if(isset($meta['type']) && $meta['type'] == 'faqs') selected @endif>Batswana Goo Faqs</option>


                        <option value="safety" @if(isset($meta['type']) && $meta['type'] == 'safety') selected @endif>Safety</option> --}}
                        <option value="vehicle_body" @if(isset($meta['type']) && $meta['type'] == 'vehicle_body') selected @endif>Vehicle Body Type</option>
                        <option value="brand" @if(isset($meta['type']) && $meta['type'] == 'brand') selected @endif>Brand</option>
                        <option value="category" @if(isset($meta['type']) && $meta['type'] == 'category') selected @endif>Categories</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6 ifCateT{{$rand}}" @if(isset($meta['type']) && $meta['type']=='category') @else style="display: none;" @endif>
                <label>Category</label>
                <select name="components[{{$rand}}][postSlider][category][]" class="form-control input-sm select2" multiple>
                    @foreach (categories() as $cates)
                        @include('frontend.includes.category_option', ['type'=>'search', 'meta'=> (isset($meta['category']) && is_array($meta['category']))?$meta['category']:[], 'cates'=>$cates, 'dash'=>'']);
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 ifMakeT{{$rand}}" @if(isset($meta['type']) && $meta['type']=='make') @else style="display: none;" @endif>
                <label>Make Models</label>
                <select name="components[{{$rand}}][postSlider][make][]" class="form-control input-sm select2" multiple>
                    @foreach (getMakes() as $make)
                        <option value="{{$make->id}}" @if(isset($meta['make']) && is_array($meta['make'])) {{(in_array($make->id, $meta['make']))?'selected':''}} @endif>{{$make->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 ifModelT{{$rand}}" @if(isset($meta['type']) && $meta['type']=='makeModel') @else style="display: none;" @endif>
                <label>Make Models</label>
                <select name="components[{{$rand}}][postSlider][makeModel][]" class="form-control input-sm select2" multiple>
                    @foreach (getMakes() as $make)
                        @if(count($make->make_model)>0)
                        <optgroup label="{{$make->name}}">
                            @foreach ($make->make_model as $model)
                                <option value="{{$model->id}}" @if(isset($meta['makeModel']) && is_array($meta['makeModel'])) {{(in_array($model->id, $meta['makeModel']))?'selected':''}} @endif>{{$make->name}} {{$model->name}}</option>
                            @endforeach
                        </optgroup>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 ifBrandT{{$rand}}" @if(isset($meta['type']) && $meta['type']=='brand') @else style="display: none;" @endif>
                <label>Brands</label>
                <select name="components[{{$rand}}][postSlider][brand][]" class="form-control input-sm select2" multiple>
                    @foreach (getBrand() as $brand)
                        <option value="{{$brand->id}}" @if(isset($meta['brand']) && is_array($meta['brand'])) {{(in_array($brand->id, $meta['brand']))?'selected':''}} @endif>{{$brand->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 ifVehicleBodyT{{$rand}}" @if(isset($meta['type']) && $meta['type']=='vehicle_body') @else style="display: none;" @endif>
                <label>Vehicle Body</label>
                <select name="components[{{$rand}}][postSlider][vehicle_body][]" class="form-control input-sm select2" multiple>
                    @foreach (getBodyTypes() as $vehiclebody)
                        <option value="{{$vehiclebody->id}}" @if(isset($meta['vehicle_body']) && is_array($meta['vehicle_body'])) {{(in_array($vehiclebody->id, $meta['vehicle_body']))?'selected':''}} @endif>{{$vehiclebody->name}}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="postSlider_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
