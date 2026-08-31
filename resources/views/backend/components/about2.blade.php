<div class="comp-item about2_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="about2_{{$rand}}" style="background: url({{asset('components/about2.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][about2][eye]" class="about2_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="about2_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_about2_{{$rand}}" style="display: none;">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group pb-2">
                    <label for="title{{$rand}}">Title</label>
                    <input type="text" placeholder="Title" class="form-control" name="components[{{$rand}}][about2][title]" value="{{$meta['title']??''}}" id="title{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="title{{$rand}}">Description</label>
                    <textarea class="form-control editor" name="components[{{$rand}}][about2][desc]" cols="30" rows="10">{{ $meta['desc'] ?? '' }}</textarea>
                </div>
                <div class="form-group pb-2">
                    <label for="img_alt{{$rand}}">Image Alt</label>
                    <input type="text" placeholder="Image Alt" class="form-control" name="components[{{$rand}}][about2][img_alt]" value="{{$meta['img_alt']??''}}" id="img_alt{{$rand}}">
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="about2CompImg-{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="about2CompImg-{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][about2][img]" value="{{$meta['img']??''}}">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="btn_txt{{$rand}}">Button Text</label>
                    <input type="text" placeholder="Button Text" class="form-control" name="components[{{$rand}}][about2][btn_txt]" value="{{$meta['btn_txt']??''}}" id="btn_txt{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="btn_link{{$rand}}">Button Link</label>
                    <input type="text" placeholder="Button Link" class="form-control" name="components[{{$rand}}][about2][btn_link]" value="{{$meta['btn_link']??''}}" id="btn_link{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="sectionID{{$rand}}">Section ID</label>
                    <input type="text" placeholder="Section ID" class="form-control" name="components[{{$rand}}][about2][sectionID]" value="{{$meta['sectionID']??''}}" id="sectionID{{$rand}}">
                </div>
                <div class="form-group">
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" id="img_pos{{$rand}}" name="components[{{$rand}}][about2][image_position]" value="1">
                        <label class="form-check-label" for="img_pos{{$rand}}">Image Left</label>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="about2_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
