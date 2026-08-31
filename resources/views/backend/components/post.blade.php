<div class="comp-item post_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="post_{{$rand}}" style="background: url({{asset('components/post.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][post][eye]" class="post_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="post_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_post_{{$rand}}" style="display: none;">
        <div class="row">

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="heading{{$rand}}">Heading</label>
                    <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][post][title]" value="{{$meta['title']??''}}" id="heading{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="btn_text{{$rand}}">Button Text</label>
                    <input type="text" placeholder="Button Text" class="form-control" name="components[{{$rand}}][post][btn_text]" value="{{$meta['btn_text']??''}}" id="btn_text{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="btn_link{{$rand}}">Button Link</label>
                    <input type="text" placeholder="Button Link" class="form-control" name="components[{{$rand}}][post][btn_link]" value="{{$meta['btn_link']??''}}" id="btn_link{{$rand}}">
                </div>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="post_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
