<div class="comp-item howDoServiceWork2_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="howDoServiceWork2_{{$rand}}" style="background: url({{asset('components/howDoServiceWork2.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][howDoServiceWork2][eye]" class="howDoServiceWork2_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="howDoServiceWork2_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_howDoServiceWork2_{{$rand}}" style="display: none;">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group pb-2">
                    <label for="howDoServiceWork2_heading{{$rand}}">Paragraph</label>
                    <textarea class="form-control editor" name="components[{{$rand}}][howDoServiceWork2][paragraph]">{!! ($meta['paragraph'])??'' !!}</textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="img_alt{{$rand}}">Image Alt</label>
                    <input type="text" placeholder="Image Alt" class="form-control" name="components[{{$rand}}][howDoServiceWork2][img_alt]" value="{{$meta['img_alt']??''}}" id="img_alt{{$rand}}">
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="howDoServiceWork2Img-{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="howDoServiceWork2Img-{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][howDoServiceWork2][img]" value="{{$meta['img']??''}}">
                    </div>
                </div>
            </div>


        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="howDoServiceWork2_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
