<div class="comp-item map_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="map_{{$rand}}" style="background: url({{asset('components/map.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][map][eye]" class="map_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="map_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_map_{{$rand}}" style="display: none;">
        <div class="row">
            <div class="col-md-4 form-group pb-2">
                <label for="heading{{$rand}}">Heading</label>
                <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][map][heading]" value="{{$meta['heading']??''}}" id="heading{{$rand}}">
            </div>
            <div class="col-md-12 form-group pb-2">
                <label for="map{{$rand}}">Map Iframe</label>
                <textarea class="form-control" name="components[{{$rand}}][map][map]" id="map{{$rand}}">{{$meta['map']??''}}</textarea>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="map_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
