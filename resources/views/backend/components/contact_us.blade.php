<div class="comp-item contact_us_eye_parent_{{$rand}} {{(isset($meta['eye']) && $meta['eye']=='on')?'':'disabled-comp'}}" id="comp-{{$rand}}">
    <div class="col-md-12 component-div" id="contact_us_{{$rand}}" style="background: url({{asset('components/contact_us.jpg')}})">
        <div class="comp-actions">
            <ul>
                <li>
                    <a href="javascript:;" class="hide_comp" data-rand="{{$rand}}">
                        <i class="fa {{(isset($meta['eye']) && $meta['eye']=='on')?'fa-eye':'fa-eye-slash'}}"></i>
                        <input type="hidden" name="components[{{$rand}}][contact_us][eye]" class="contact_us_eye_{{$rand}}" value="{{(isset($meta['eye']) && $meta['eye']=='on')?'on':'off'}}" />
                    </a>
                </li>
                <li><a href="javascript:;" class="edit_comp" data-id="contact_us_{{$rand}}"><i class="fa fa-edit"></i></a></li>
                <li><a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a></li>
                <li><a href="javascript:;" class="remove_comp" data-rand="{{$rand}}"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 component-edit-div" id="edit_contact_us_{{$rand}}" style="display: none;">
        <div class="row">
            <div class="col-md-12">                          
                <div class="mb-4">
                    <label class="form-label" for="page_title">Page Title (H1)</label>
                    <input type="text" class="js-maxlength form-control" id="page_title" name="components[{{$rand}}][contact_us][page_title]" data-always-show="true" data-placement="top" value="{{$meta['page_title']??''}}">
                    {{-- <div class="form-text">
                      55 Character Max
                    </div> --}}
                  </div>                
                  <div class="mb-3">
                    <label class="form-label" for="page_description">Page Description</label>
                    <textarea class="js-maxlength form-control" id="page_description" name="components[{{$rand}}][contact_us][page_description]" rows="4" data-always-show="true" data-placement="top">{{$meta['page_description']??''}}</textarea>
                    {{-- <div class="form-text">
                      115 Character Max
                    </div> --}}
                  </div>                                            
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-4 form-group pb-2">
                <label for="form_heading{{$rand}}">Form Heading</label>
                <input type="text" placeholder="Form Heading" class="form-control" name="components[{{$rand}}][contact_us][form_heading]" value="{{$meta['form_heading']??''}}" id="form_heading{{$rand}}">
            </div>
            <div class="col-md-4 form-group pb-2">
                <label for="detail_heading{{$rand}}">Detail Heading</label>
                <input type="text" placeholder="Detail Heading" class="form-control" name="components[{{$rand}}][contact_us][detail_heading]" value="{{$meta['detail_heading']??''}}" id="detail_heading{{$rand}}">
            </div>

            <!-- Address -->
                <div class="col-md-12 mt-2">
                    <h5>Address</h5>
                </div>

                <div class="col-md-3 form-group">
                    <label for="">Image</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="addImg-{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="addImg-{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][contact_us][address][img]" value="{{$meta['address']['img']??''}}">
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <label for="img_alt{{$rand}}">Image Alt</label>
                    <input type="text" placeholder="Image Alt" class="form-control" name="components[{{$rand}}][contact_us][address][img_alt]" value="{{$meta['address']['img_alt']??''}}" id="img_alt{{$rand}}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="add_heading{{$rand}}">Heading</label>
                    <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][contact_us][address][heading]" value="{{$meta['address']['heading']??''}}" id="add_heading{{$rand}}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="add_text{{$rand}}">Text</label>
                    <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][contact_us][address][text]" value="{{$meta['address']['text']??''}}" id="add_text{{$rand}}">
                </div>
            <!-- Address -->

            <!-- Phone -->
                <div class="col-md-12 mt-2">
                    <h5>Phone</h5>
                </div>

                <div class="col-md-3 form-group">
                    <label for="">Image</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="addImg-{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="addImg-{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][contact_us][phone][img]" value="{{$meta['phone']['img']??''}}">
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <label for="img_alt{{$rand}}">Image Alt</label>
                    <input type="text" placeholder="Image Alt" class="form-control" name="components[{{$rand}}][contact_us][phone][img_alt]" value="{{$meta['phone']['img_alt']??''}}" id="img_alt{{$rand}}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="add_heading{{$rand}}">Heading</label>
                    <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][contact_us][phone][heading]" value="{{$meta['phone']['heading']??''}}" id="add_heading{{$rand}}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="add_text{{$rand}}">Text</label>
                    <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][contact_us][phone][text]" value="{{$meta['phone']['text']??''}}" id="add_text{{$rand}}">
                </div>
            <!-- Phone -->

            <!-- Office Hours -->
                <div class="col-md-12 mt-2">
                    <h5>Office Hours</h5>
                </div>

                <div class="col-md-3 form-group">
                    <label for="">Image</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="addImg-{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="addImg-{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][contact_us][hour][img]" value="{{$meta['hour']['img']??''}}">
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <label for="img_alt{{$rand}}">Image Alt</label>
                    <input type="text" placeholder="Image Alt" class="form-control" name="components[{{$rand}}][contact_us][hour][img_alt]" value="{{$meta['hour']['img_alt']??''}}" id="img_alt{{$rand}}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="add_heading{{$rand}}">Heading</label>
                    <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][contact_us][hour][heading]" value="{{$meta['hour']['heading']??''}}" id="add_heading{{$rand}}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="add_text{{$rand}}">Text</label>
                    <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][contact_us][hour][text]" value="{{$meta['hour']['text']??''}}" id="add_text{{$rand}}">
                </div>
            <!-- Office Hours -->

            <!-- Email -->
                <div class="col-md-12 mt-2">
                    <h5>Email</h5>
                </div>

                <div class="col-md-3 form-group">
                    <label for="">Image</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="addImg-{{$rand}}" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="addImg-{{$rand}}" class="form-control input-sm" type="text" name="components[{{$rand}}][contact_us][email][img]" value="{{$meta['email']['img']??''}}">
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <label for="img_alt{{$rand}}">Image Alt</label>
                    <input type="text" placeholder="Image Alt" class="form-control" name="components[{{$rand}}][contact_us][email][img_alt]" value="{{$meta['email']['img_alt']??''}}" id="img_alt{{$rand}}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="add_heading{{$rand}}">Heading</label>
                    <input type="text" placeholder="Heading" class="form-control" name="components[{{$rand}}][contact_us][email][heading]" value="{{$meta['email']['heading']??''}}" id="add_heading{{$rand}}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="add_text{{$rand}}">Text</label>
                    <input type="text" placeholder="Text" class="form-control" name="components[{{$rand}}][contact_us][email][text]" value="{{$meta['email']['text']??''}}" id="add_text{{$rand}}">
                </div>
            <!-- Email -->

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-xs btn-success save_comp" data-id="contact_us_{{$rand}}">save</a>
            </div>
        </div>
    </div>
</div>
