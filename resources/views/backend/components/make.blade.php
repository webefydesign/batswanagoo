<div class="comp-item make_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="make_{{$rand}}" style="background: url({{asset('components/make.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][make][eye]" class="make_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="make_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_make_{{$rand}}" style="display: none;">
        <div class="row">

            <div class="col-md-6 form-group pb-2">
                <label for="heading{{$rand}}">Heading</label>
                <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][make][title]" value="{{$meta['title']??''}}" id="heading{{$rand}}">
            </div>

            <div class="col-md-6 form-group pb-2">
                <label for="btn_txt{{$rand}}">Button Text</label>
                <input type="text" placeholder="Button Text" class="form-control" name="components[{{$rand}}][make][btn_txt]" value="{{$meta['btn_txt']??''}}" id="btn_txt{{$rand}}">
            </div>

            <div class="col-md-6 form-group pb-2">
                <label for="btn_link{{$rand}}">Button Link</label>
                <input type="text" placeholder="Button Link" class="form-control" name="components[{{$rand}}][make][btn_link]" value="{{$meta['btn_link']??''}}" id="btn_link{{$rand}}">
            </div>

            <div class="col-md-6 form-group pb-2">
                <label for="text{{$rand}}">Text</label>
                <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][make][text]" value="{{$meta['text']??''}}" id="text{{$rand}}">
            </div>

            <div class="col-md-6">
                <div class="form-group pb-2">
                    <label for="type{{$rand}}">Slider Or Boxes</label>
                    <select name="components[{{$rand}}][make][slider]" class="form-control input-sm select2" id="type{{$rand}}" data-rand="{{$rand}}">
                        <option value="" disabled selected style="display:none">Choose Any</option>
                        <option value="slider" {{(isset($meta['slider']) && $meta['slider']=='slider')?'selected':''}}>Slider</option>
                    <option value="box" {{(isset($meta['slider']) && $meta['slider']=='box')?'selected':''}}>Boxes</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group pb-2">
                    <label for="type{{$rand}}">Show</label>
                    <select name="components[{{$rand}}][make][show]" class="form-control input-sm select2 isCateT" id="type{{$rand}}" data-rand="{{$rand}}">
                        <option value="makeModel" {{(isset($meta['show']) && $meta['show']=='makeModel')?'selected':''}}>Make</option>
                        <option value="category" {{(isset($meta['show']) && $meta['show']=='category')?'selected':''}}>Categories</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6 ifCateT{{$rand}}" @if(isset($meta['type']) && $meta['type']=='category') @else style="display: none;" @endif>
                <label>Category</label>
                <select name="components[{{$rand}}][make][category][]" class="form-control input-sm select2">
                    @foreach (categories() as $cates)
                        @include('frontend.includes.category_option', ['type'=>'search', 'meta'=> (isset($meta['category']) && is_array($meta['category']))?$meta['category']:[], 'cates'=>$cates, 'dash'=>'']);
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 ifModelT{{$rand}}" @if(isset($meta['type']) && $meta['type']=='makeModel') @else style="display: none;" @endif>
                <label>Make Models</label>
                <select name="components[{{$rand}}][make][makeModel][]" class="form-control input-sm select2" multiple>
                    @foreach (getMakes() as $make)
                        @if(count($make->make_model)>0)
                            <option value="{{$make->id}}">{{$make->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- <div class="form-group col-md-6 ifFaqT{{$rand}}" @if(isset($meta['type']) && $meta['type']=='faqs') @else style="display: none;" @endif>
                <label>Faqs</label>
                <select name="components[{{$rand}}][make][faqs][]" class="form-control input-sm select2" multiple>
                    @foreach (getFaqs() as $faq)
                        <option value="{{$faq->id}}">{{$faq->title}}</option>
                    @endforeach
                </select>
            </div> --}}

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="make_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
