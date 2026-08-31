<div class="comp-item search_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="search_{{$rand}}" style="background: url({{asset('components/search.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][search][eye]" class="search_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="search_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_search_{{$rand}}" style="display: none;">
        <div class="row">

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="heading{{$rand}}">Heading</label>
                    <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][search][title]" value="{{$meta['title']??''}}" id="heading{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="text{{$rand}}">Text</label>
                    <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][search][text]" value="{{$meta['text']??''}}" id="text{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="category{{$rand}}">Category</label>
                    <select name="components[{{$rand}}][search][category][]" class="form-control input-sm select2" multiple="" id="category{{$rand}}">
                        @foreach (categories() as $cates)
                            @include('frontend.includes.category_option', ['type'=>'search', 'meta'=> (isset($meta['category']) && is_array($meta['category']))?$meta['category']:[], 'cates'=>$cates, 'dash'=>'']);
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="place_type{{$rand}}">Place Type</label>
                    <select name="components[{{$rand}}][search][place_type]" class="form-control input-sm" id="place_type{{$rand}}">
                        <option value="countries" @if(isset($meta['place_type']) && $meta['place_type']=='countries') selected @endif>Countries</option>
                        <option value="states" @if(isset($meta['place_type']) && $meta['place_type']=='states') selected @endif>States</option>
                        <option value="cities" @if(isset($meta['place_type']) && $meta['place_type']=='cities') selected @endif>Cities</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="country{{$rand}}">Country</label>
                    <select name="components[{{$rand}}][search][country]" class="form-control input-sm" id="country{{$rand}}">
                        @foreach (getCountries() as $co => $country)
                            <option value="{{$country}}" @if(isset($meta['country']) && $meta['country']==$country) selected @endif>{{$co}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="search_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
