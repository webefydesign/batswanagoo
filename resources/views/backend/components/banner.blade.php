<div class="comp-item banner_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="banner_{{$rand}}" style="background: url({{asset('components/banner.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][banner][eye]" class="banner_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="banner_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_banner_{{$rand}}" style="display: none;">
        <div class="row">

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="pagename{{$rand}}">Page Name</label>
                    <input type="text" placeholder="Page Name" class="form-control" name="components[{{$rand}}][banner][page_name]" value="{{$meta['page_name']??''}}" id="pagename{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="heading1{{$rand}}">Heading 1</label>
                    <input type="text" placeholder="Heading 1" class="form-control" name="components[{{$rand}}][banner][title1]" value="{{$meta['title1']??''}}" id="heading1{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="heading2{{$rand}}">Heading 2</label>
                    <input type="text" placeholder="Heading 2" class="form-control" name="components[{{$rand}}][banner][title2]" value="{{$meta['title2']??''}}" id="heading2{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for=""><b>Background Image <small>(1400x220)</small>:</b> <br> <small>if you leave blank the below field it will show <b>default background</b></small></label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="pageTitleBg-{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="pageTitleBg-{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][banner][bg]" value="{{$meta['bg']??''}}">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label style="display: block;">No Of Record</label>
                    <select id="noofbreadcurm{{$rand}}" class="form-control" style="width:80%;display: inline-block;">
                        @for($i=1; $i<=5; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                    <button type="button" class="btn btn-sm btn-primary addbreadcurm" style="margin-bottom: 0px;padding: 3px 8px !important;" data-key="{{$rand}}">ADD</button>
                </div>
            </div>

            <div class="col-md-12" id="styleBreadcurm{{$rand}}">
                @if(isset($meta['arr']))
                    @foreach($meta['arr'] as $i => $val1)
                    <div class="form-group col-md-3 mt-1" style="border:solid 1px #eaeaea;border-radius:5px;padding:14px 0px 0px 0px;position:relative;display:inline-block;">
                            <button type="button" class="btn btn-sm btn-danger RemoveBreadcurm" style="position: absolute;right: 2px;top: 2px;font-size: 0.5rem;">
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                            <div class="form-group col-md-11">
                                <input type="text" name="components[{{$rand}}][banner][arr][{{$i}}][title]" class="form-control input-sm" placeholder="Title" value="{{ ($val1['title'])??'' }}">
                            </div>

                            <div class="form-group col-md-11">
                                <input type="text" name="components[{{$rand}}][banner][arr][{{$i}}][link]" class="form-control input-sm" placeholder="Text" value="{{ ($val1['link'])??'' }}">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="banner_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
