<div class="comp-item recommended_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="recommended_{{$rand}}" style="background: url({{asset('components/recommended.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][recommended][eye]" class="recommended_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="recommended_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_recommended_{{$rand}}" style="display: none;">
        <div class="row">

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="heading{{$rand}}">Heading</label>
                    <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][recommended][title]" value="{{$meta['title']??''}}" id="heading{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="text{{$rand}}">Text</label>
                    <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][recommended][text]" value="{{$meta['text']??''}}" id="text{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="btn_text{{$rand}}">Button Text</label>
                    <input type="text" placeholder="Button Text" class="form-control" name="components[{{$rand}}][recommended][btn_text]" value="{{$meta['btn_text']??''}}" id="btn_text{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="btn_link{{$rand}}">Button Link</label>
                    <input type="text" placeholder="Button Link" class="form-control" name="components[{{$rand}}][recommended][btn_link]" value="{{$meta['btn_link']??''}}" id="btn_link{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="">Side Ad 1</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="thumbnail_recommended1_{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="thumbnail_recommended1_{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][recommended][image1]" value="{{$meta['image1']??''}}">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="side_link1{{$rand}}">Side Ad 1 Link</label>
                    <input type="text" placeholder="Button Link" class="form-control" name="components[{{$rand}}][recommended][side_link1]" value="{{$meta['side_link1']??''}}" id="side_link1{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="">Side Ad 2</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="thumbnail_recommended2_{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="thumbnail_recommended2_{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][recommended][image2]" value="{{$meta['image2']??''}}">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="side_link2{{$rand}}">Side Ad 2 Link</label>
                    <input type="text" placeholder="Button Link" class="form-control" name="components[{{$rand}}][recommended][side_link2]" value="{{$meta['side_link2']??''}}" id="side_link2{{$rand}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="list{{$rand}}">List Ads</label>
                    <select name="components[{{$rand}}][recommended][list]" class="form-control input-sm" id="list{{$rand}}">
                        <optgroup label="Categories">
                            <option value="category" {{(isset($meta['list']) && $meta['list'] == 'category')?'selected':''}}>Category</option>
                        </optgroup>
                        <optgroup label="Promotions">
                            @foreach (allPromotes() as $promo)
                                <option value="{{$promo->id}}" {{(isset($meta['list']) && $meta['list'] == $promo->id)?'selected':''}}>{{$promo->name}}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="category{{$rand}}">Category</label>
                    <select name="components[{{$rand}}][recommended][category][]" class="form-control input-sm select2" multiple="" id="category{{$rand}}">
                        @foreach (categories() as $cates)
                            @include('frontend.includes.category_option', ['type'=>'search', 'meta'=> (isset($meta['category']) && is_array($meta['category']))?$meta['category']:[], 'cates'=>$cates, 'dash'=>'']);
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group pb-2">
                    <label for="category{{$rand}}">Limit</label>
                    <input type="number" name="components[{{$rand}}][recommended][limit]" class="form-control input-sm" value="{{$meta['limit']??12}}">
                </div>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="recommended_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
