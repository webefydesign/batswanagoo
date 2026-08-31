<div class="comp-item cateSearch_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="province_{{$rand}}" style="background: url({{asset('components/province.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][province][eye]" class="province_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="province_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_province_{{$rand}}" style="display: none;">
        <div class="row">

            <div class="col-md-4 form-group pb-2">
                <label for="heading{{$rand}}">Heading</label>
                <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][province][title]" value="{{$meta['title']??''}}" id="heading{{$rand}}">
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="category{{$rand}}">Category</label>
                    <select name="components[{{$rand}}][province][category]" class="form-control input-sm select2" id="category{{$rand}}" data-rand="{{$rand}}">
                        @foreach (categories() as $cates)
                            @include('frontend.includes.category_option', ['type'=>'search', 'meta'=> (isset($meta['category']) && !is_array($meta['category']))?$meta['category']:[], 'cates'=>$cates, 'dash'=>'']);
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="slide{{$rand}}">Show Country/State/City</label>
                    <select name="components[{{$rand}}][province][slide]" class="form-control input-sm select2 csc" id="slide{{$rand}}" data-rand="{{$rand}}">
                        <option value="country" {{(isset($meta['slide']) && $meta['slide']=='country')?'selected':null}}>Country</option>
                        <option value="state" {{(isset($meta['slide']) && $meta['slide']=='state')?'selected':null}}>State</option>
                        <option value="city" {{(isset($meta['slide']) && $meta['slide']=='city')?'selected':null}}>City</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4 state_{{$rand}}" @if(isset($meta['slide']) && ($meta['slide']=='city' || $meta['slide']=='state')) @else style="display: none;" @endif>
                <label>Country</label>
                <select name="components[{{$rand}}][province][country]" class="form-control input-sm countryChange" data-rand="{{$rand}}">
                    <option value="">Select Country</option>
                    @foreach(getCountries() as $c => $country)
                        <option value="{{$country}}" {{(isset($meta['country']) && $meta['country']==$country)?'selected':null}}>{{$c}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4 city_{{$rand}}" @if(isset($meta['slide']) && $meta['slide']=='city') @else style="display: none;" @endif>
                <label>States</label>
                <select name="components[{{$rand}}][province][state]" class="form-control input-sm state_select_{{$rand}}">
                    @foreach(getStates(($meta['country'])??0) as $key => $state)
                        <option value="{{$state}}" {{(isset($meta['state']) && $meta['state']==$state)?'selected':null}}>{{$key}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="province_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
