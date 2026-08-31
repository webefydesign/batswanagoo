<div class="comp-item editor_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="editor_{{$rand}}" style="background: url({{asset('components/editor.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][editor][eye]" class="editor_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="editor_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_editor_{{$rand}}" style="display: none;">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group pb-2">
                    <label for="title{{$rand}}">Heading</label>
                    <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][editor][title]" value="{{$meta['title']??''}}" id="title{{$rand}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" id="center{{$rand}}" name="components[{{$rand}}][editor][center]" value="1" @if(isset($meta['center']) && $meta['center']*1 === 1) checked @endif>
                        <label class="form-check-label" for="center{{$rand}}">Center</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group pb-2">
                    <label for="title{{$rand}}">Paragraph</label>
                    <textarea class="form-control editor" name="components[{{$rand}}][editor][desc]" cols="30" rows="10">{{ $meta['desc'] ?? '' }}</textarea>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="editor_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
