<div class="comp-item brands_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="brands_{{$rand}}" style="background: url({{asset('components/brands.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][brands][eye]" class="brands_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="brands_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_brands_{{$rand}}" style="display: none;">
        <div class="row">
            <div class="col-md-12">
                <h5 align="center">Brands</h5>
            </div>
            <div class="col-md-4 form-group pb-2">
                <label for="heading{{$rand}}">Heading</label>
                <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][brands][heading]" value="{{$meta['heading']??''}}" id="heading{{$rand}}">
            </div>
            <div class="col-md-8 form-group pb-2">
                <label for="desc{{$rand}}">Description</label>
                <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][brands][desc]" value="{{$meta['desc']??''}}" id="desc{{$rand}}">
            </div>
            <hr />
            <div class="col-md-4 form-group pb-2">
                <label for="text{{$rand}}">Text</label>
                <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][brands][text]" value="{{$meta['text']??''}}" id="text{{$rand}}">
            </div>

            <div class="col-md-4 form-group pb-2">
                <label for="btn_text{{$rand}}">Button Text</label>
                <input type="text" placeholder="Button Text" class="form-control" name="components[{{$rand}}][brands][btn_text]" value="{{$meta['btn_text']??''}}" id="btn_text{{$rand}}">
            </div>

            <div class="col-md-4 form-group pb-2">
                <label for="btn_link{{$rand}}">Button Link</label>
                <input type="text" placeholder="Button Link" class="form-control" name="components[{{$rand}}][brands][btn_link]" value="{{$meta['btn_link']??''}}" id="btn_link{{$rand}}">
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="brands_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
