<div class="comp-item topcates_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="topcates_{{$rand}}" style="background: url({{asset('components/topcates.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][topcates][eye]" class="topcates_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="topcates_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_topcates_{{$rand}}" style="display: none;">
        <div class="row">

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="heading{{$rand}}">Heading</label>
                    <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][topcates][title]" value="{{$meta['title']??''}}" id="heading{{$rand}}">
                </div>
            </div>

            <div class="form-group col-sm-4">
                <button class="btn btn-xs btn-success addBox" data-comp="topcates" data-rand="{{$rand}}" type="button" style="margin-top:23px;"> Add Box</button>
            </div>

            <div class="row el_box_row_{{$rand}}">
                @if(isset($meta['top']) && count($meta['top'])>0)
                    @foreach($meta['top'] as $i => $value)
                        <div class="col-sm-12 el_col">
                            <h5>Top #{{$i+1}}
                                <a href="javascript:void(0);" class="removeBox" style="float:right;color:#ca0303;"> <i class="fa fa-times"></i> </a>
                            </h5>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group pb-2">
                                        <label for="">Image</label>
                                        <div class="input-group pull-left">
                                            <span class="input-group-btn">
                                                <a data-input="thumbnail_top{{$i}}_{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                            </span>
                                            <input id="thumbnail_top{{$i}}_{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][topcates][top][{{$i}}][image]" value="{{$value['image']??''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Title</label>
                                        <div style="position: relative;">
                                            <input type="text" class="form-control input-sm" name="components[{{$rand}}][topcates][top][{{$i}}][title]" value="{{$value['title']??''}}" />
                                            <input type="color" class="form-control input-sm" name="components[{{$rand}}][topcates][top][{{$i}}][color]" value="{{$value['color']??''}}" style="position:absolute;right: 1%;width: 50px;padding: 0px 0px;top: 50%;transform: translate(0%, -50%);" />
                                        </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Link</label>
                                    <input type="text" class="form-control input-sm" name="components[{{$rand}}][topcates][top][{{$i}}][link]" value="{{$value['link']??''}}" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="topcates_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
