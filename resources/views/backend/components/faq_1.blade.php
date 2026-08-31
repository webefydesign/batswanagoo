<div class="comp-item faq_1_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="faq_1_{{$rand}}" style="background: url({{asset('components/faq_1.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][faq_1][eye]" class="faq_1_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="faq_1_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_faq_1_{{$rand}}" style="display: none;">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group pb-2">
                    <label for="category{{$rand}}">Category</label>
                    <select name="components[{{$rand}}][faq_1][category][]" class="form-control input-sm select2" id="category{{$rand}}">
                        @foreach (categories() as $cates)
                            @include('frontend.includes.category_option', ['type'=>'search', 'meta'=> (isset($meta['category']) && is_array($meta['category']))?$meta['category']:[], 'cates'=>$cates, 'dash'=>'']);
                        @endforeach
                    </select>
                </div>
                <div class="form-group pb-2">
                    <label for="faq_1_heading{{$rand}}">Paragraph</label>
                    <textarea class="form-control editor" name="components[{{$rand}}][faq_1][paragraph]">{!! ($meta['paragraph'])??'' !!}</textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="faq_1_heading{{$rand}}">Faq Heading</label>
                    <input type="text" placeholder="Faq Heading" class="form-control" name="components[{{$rand}}][faq_1][faq_heading]" value="{{$meta['faq_heading']??''}}" id="faq_1_heading{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="heading{{$rand}}">Heading</label>
                    <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][faq_1][heading]" value="{{$meta['heading']??''}}" id="heading{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="btn_txt{{$rand}}">Button Text</label>
                    <input type="text" placeholder="Button Text" class="form-control" name="components[{{$rand}}][faq_1][btn_txt]" value="{{$meta['btn_txt']??''}}" id="btn_txt{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="btn_link{{$rand}}">Button Link</label>
                    <input type="text" placeholder="Button Link" class="form-control" name="components[{{$rand}}][faq_1][btn_link]" value="{{$meta['btn_link']??''}}" id="btn_link{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="img_alt{{$rand}}">Image Alt</label>
                    <input type="text" placeholder="Image Alt" class="form-control" name="components[{{$rand}}][faq_1][img_alt]" value="{{$meta['img_alt']??''}}" id="img_alt{{$rand}}">
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="faq_1Img-{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="faq_1Img-{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][faq_1][img]" value="{{$meta['img']??''}}">
                    </div>
                </div>
            </div>


        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="faq_1_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
