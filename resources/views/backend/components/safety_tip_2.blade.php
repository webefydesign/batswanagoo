<div class="comp-item safety_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="safety_{{$rand}}" style="background: url({{asset('components/safety.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][safety][eye]" class="safety_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="safety_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_safety_{{$rand}}" style="display: none;">
        <div class="row">

            <div class="col-md-4 form-group pb-2">
                <label for="main_heading{{$rand}}">Main Heading</label>
                <input type="text" placeholder="Main Heading" class="form-control" name="components[{{$rand}}][safety][title]" value="{{$meta['title']??''}}" id="main_heading{{$rand}}">
            </div>

            <div class="col-md-4 form-group pb-2">
                <label for="title2{{$rand}}">Tips 1 Heading</label>
                <input type="text" placeholder="Tips 1 Heading" class="form-control" name="components[{{$rand}}][safety][title2]" value="{{$meta['title2']??''}}" id="title2{{$rand}}">
            </div>

            <div class="col-md-4 form-group pb-2">
                <label for="title3{{$rand}}">Tips 2 Heading</label>
                <input type="text" placeholder="Tips 2 Heading" class="form-control" name="components[{{$rand}}][safety][title3]" value="{{$meta['title3']??''}}" id="title3{{$rand}}">
            </div>

            <div class="col-md-4 form-group pb-2">
                <label for="error{{$rand}}">Error Message</label>
                <input type="text" placeholder="Error Message" class="form-control" name="components[{{$rand}}][safety][error]" value="{{$meta['error']??''}}" id="error{{$rand}}">
            </div>

            <div class="col-md-4 form-group pb-2">
                <label for="info{{$rand}}">Information</label>
                <textarea class="form-control" name="components[{{$rand}}][safety][info]" id="info{{$rand}}">{!! ($meta['info'])??'' !!}</textarea>
            </div>

            <div class="col-md-4 form-group pb-2">
                <label>Safety Tips Vertical</label>
                <select name="components[{{$rand}}][safety][tips1][]" class="form-control input-sm select2" multiple="">
                    @foreach (getSafety() as $safety)
                        <option value="{{$safety->id}}" @if(isset($meta['tips1']) && in_array($safety->id, $meta['tips1'])) selected @endif>{{$safety->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 form-group pb-2">
                <label>Safety Tips Columns</label>
                <select name="components[{{$rand}}][safety][tips2][]" class="form-control input-sm select2" multiple="">
                    @foreach (getSafety() as $safety)
                        <option value="{{$safety->id}}" @if(isset($meta['tips2']) && in_array($safety->id, $meta['tips2'])) selected @endif>{{$safety->title}}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="safety_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
