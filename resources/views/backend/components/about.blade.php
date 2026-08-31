<div class="comp-item about_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="about_{{$rand}}" style="background: url({{asset('components/about.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][about][eye]" class="about_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="about_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_about_{{$rand}}" style="display: none;">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="title{{$rand}}">Title</label>
                    <input type="text" placeholder="Title" class="form-control" name="components[{{$rand}}][about][title]" value="{{$meta['title']??''}}" id="title{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="title{{$rand}}">Description</label>
                    <textarea class="form-control" name="components[{{$rand}}][about][desc]" cols="30" rows="10">{{ $meta['desc'] ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="aboutCompImg-{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="aboutCompImg-{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][about][img]" value="{{$meta['img']??''}}">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="section1{{$rand}}">Section 1</label>
                    <input type="text" placeholder="Section 1" class="form-control" name="components[{{$rand}}][about][section1]" value="{{$meta['section1']??''}}" id="section1{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="section2{{$rand}}">Section 2</label>
                    <input type="text" placeholder="Section 2" class="form-control" name="components[{{$rand}}][about][section2]" value="{{$meta['section2']??''}}" id="section2{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="section3{{$rand}}">Section 3</label>
                    <input type="text" placeholder="Section 3" class="form-control" name="components[{{$rand}}][about][section3]" value="{{$meta['section3']??''}}" id="section3{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="section4{{$rand}}">Section 4</label>
                    <input type="text" placeholder="Section 4" class="form-control" name="components[{{$rand}}][about][section4]" value="{{$meta['section4']??''}}" id="section4{{$rand}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="section1ID{{$rand}}">Section 1 ID</label>
                    <input type="text" placeholder="Section 1 ID" class="form-control" name="components[{{$rand}}][about][section1ID]" value="{{$meta['section1ID']??''}}" id="section1ID{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="section2ID{{$rand}}">Section 2 ID</label>
                    <input type="text" placeholder="Section 2 ID" class="form-control" name="components[{{$rand}}][about][section2ID]" value="{{$meta['section2ID']??''}}" id="section2ID{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="section3ID{{$rand}}">Section 3 ID</label>
                    <input type="text" placeholder="Section 3 ID" class="form-control" name="components[{{$rand}}][about][section3ID]" value="{{$meta['section3ID']??''}}" id="section3ID{{$rand}}">
                </div>
                <div class="form-group pb-2">
                    <label for="section4ID{{$rand}}">Section 4 ID</label>
                    <input type="text" placeholder="Section 4 ID" class="form-control" name="components[{{$rand}}][about][section4ID]" value="{{$meta['section4ID']??''}}" id="section4ID{{$rand}}">
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="about_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
