<div class="comp-item cateSearch_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="cateSearch_{{$rand}}" style="background: url({{asset('components/cateSearch.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][cateSearch][eye]" class="cateSearch_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="cateSearch_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_cateSearch_{{$rand}}" style="display: none;">
        <div class="row">

            <div class="col-md-6 form-group pb-2">
                <label for="heading{{$rand}}">Heading</label>
                <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][cateSearch][title]" value="{{$meta['title']??''}}" id="heading{{$rand}}">
            </div>

            <div class="col-md-6">
                <div class="form-group pb-2">
                    <label for="category{{$rand}}">Category</label>
                    <select name="components[{{$rand}}][cateSearch][category]" class="form-control input-sm select2 categoryParentC" id="category{{$rand}}" data-rand="{{$rand}}">
                        @foreach (categories() as $cates)
                            @include('frontend.includes.category_option', ['type'=>'search', 'meta'=> (isset($meta['category']) && !is_array($meta['category']))?$meta['category']:[], 'cates'=>$cates, 'dash'=>'']);
                        @endforeach
                    </select>
                </div>
            </div>

            @if(isset($meta['category']))
                @php
                    $s = 0;
                    $gCateory = getCategory($meta['category']);
                    if($gCateory != null && count($gCateory->childrens)>0){
                        $s=1;
                    }
                @endphp
            @endif

            <div class="col-md-6 hideC_{{$rand}}" @if(isset($s) && $s == 1) @else style="display:none;" @endif>
                <div class="form-check form-switch">
                    <label class="form-check-label" for="cateSearch-{{$rand}}">Show Sub Category Tabs</label>
                    <input class="form-check-input" type="checkbox" id="cateSearch-{{$rand}}" name="components[{{$rand}}][cateSearch][sub]" value="1" {{(isset($meta['sub']) && $meta['sub']==1)?'checked':''}}>
                </div>
            </div>

            <div class="col-md-6 hideC_{{$rand}}" @if(isset($s) && $s == 1) @else style="display:none;" @endif>
                <div class="form-group pb-2">
                    <label for="subcategory{{$rand}}">Sub Categories</label>
                    <select name="components[{{$rand}}][cateSearch][sub_categories][]" class="form-control input-sm select2 subCates_{{$rand}}" id="subcategory{{$rand}}" multiple>
                        @if(isset($gCateory))
                            @foreach ($gCateory->childrens as $cates)
                                @include('frontend.includes.category_option', ['type'=>'search', 'meta'=> (isset($meta['sub_categories']) && is_array($meta['sub_categories']))?$meta['sub_categories']:[], 'cates'=>$cates, 'dash'=>'']);
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="cateSearch_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
