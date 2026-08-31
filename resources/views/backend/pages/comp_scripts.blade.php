<script>

    $(window).on('load', function() {
        checkComponents();
    });

    $(document).ready(function(){
        initEditor();
        $("#components").sortable({
          handle: ".handle",
          axis: 'y'
        });
    });
    $(document).on('click','.edit_comp',function(){
        var id = $(this).data('id');
        $('.image-placeholder').filemanager('image');
        $("#"+id).slideUp();
        $(".slides-list").sortable({
          handle: ".move-slide",
          axis: 'y'
        });
        initEditor();
        $(".select2").select2({
            width:'100%'
        });
        $("#edit_"+id).show();
    });

    $(document).on('click','.save_comp',function(){
        var id = $(this).data('id');
        $("#"+id).slideDown();
        $("#edit_"+id).hide();
    });

    $(document).on('click','.remove_comp',function(){
        $("#comp-"+$(this).data('rand')).remove();
        checkComponents();
    });

    $(document).on('click','.hide_comp',function(){
        var rand = $(this).data('rand');
        $("#comp-"+rand).toggleClass('disabled-comp');
        hiddenField = $(this).find('input');
        val = hiddenField.val();
        hiddenField.val(val === "on" ? "off" : "on");
        $(this).find('i').toggleClass('fa-eye-slash fa-eye');
    });
    $(".component").click(function(){
        var comp = $(this).data('comp');
        var data = { '_token':"{{csrf_token()}}", 'comp':$(this).data('comp') };
        jQuery.ajax({
            url:'{{route("ajaxGetComps")}}',
            type: 'post',
            data: data,
            success: function( data ){
                $("#page-components").append(data.html);
                $('.'+comp+'_eye_'+data.rand).val('on');
                $('.'+comp+'_eye_'+data.rand).parent().find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                $('.'+comp+'_eye_parent_'+data.rand).removeClass('disabled-comp');
                checkComponents();
            }
        });
    });

    function initEditor() {
        tinymce.init({
            selector: '.editor',
            plugins: 'anchor autolink charmap emoticons image link lists media searchreplace table visualblocks wordcount media linkchecker code textcolor',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | link image media table | align lineheight | numlist bullist indent outdent | removeformat | code',
            menubar: false,
            file_picker_types: 'image',
            image_dimensions: false,
            relative_urls: false,
            remove_script_host: false,
            file_picker_callback: function(cb, value, meta) {
                var route_prefix = "/filemanager"; // Update it to your Laravel Filemanager URL
                window.open(route_prefix + '?type=' + meta.filetype, 'FileManager', 'width=900,height=600');
                window.SetUrl = function (items) {
                    var file_path = items.map(function (item) {
                        return item.url;
                    }).join(',');
                    // set the value of the desired input to image url
                    cb(file_path, { alt: items[0].alt || '' });
                };
            }
        });
    }

    function checkComponents() {
        var $pageComponents = $('#page-components');
        var $noCompsDiv = $('#no-comps');

        var hasComponents = $pageComponents.find('.comp-item').length > 0;

        if (hasComponents) {
            if ($noCompsDiv.length) {
                $noCompsDiv.remove();
            }
        } else {
            if (!$noCompsDiv.length) {
                var newNoCompsDiv = $('<div id="no-comps"><h1>Add your first component by <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#comps-modal">clicking here</a></h1></div>');
                $pageComponents.append(newNoCompsDiv);
            }
        }
    }
</script>
<script>
    /*  Slider */
    $(document).on('click', ".add-slide", function(){
        _rand = $(this).data('rand');
        $("#slider-modal-"+_rand).modal('show');
    });
    $(document).on('click', ".save-slide", function(){
        var _rand = $(this).data('rand');
        var s_top_title = $("#slideTopTitleInput-"+_rand).val();
        var s_title = $("#slideTitleInput-"+_rand).val();
        var s_desc = $("#slideDescriptionInput-"+_rand).val();
        var s_img = $("#slideImg-"+_rand).val();
        var s_btn_text = $("#slideBTextInput-"+_rand).val();
        var s_btn_link = $("#slideBLinkInput-"+_rand).val();
        var um = Math.floor(Math.random() * 99999)
        $("#slides-list-"+_rand).append(`
            <tr>
                <td colspan="4">
                    <table class="table table-vcenter">
                        <tr>
                            <td><a href="javascript:;" class="btn btn-link btn-xs move-slide"><i class="fa fa-bars"></i></a></td>
                            <td>`+s_top_title+`</td>
                            <td>`+s_title+`</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled edit-slide" data-bs-toggle="tooltip" aria-label="Edit Slide" data-bs-original-title="Edit Slide" data-uid="`+um+`-`+_rand+`">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled delete-slide" data-bs-toggle="tooltip" aria-label="Remove Slide" data-bs-original-title="Remove Slide">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="slideIns" id="slideDetail-`+um+`-`+_rand+`" style="display: none;">
                        <div class="form-group pb-2">
                            <input type="text" class="form-control" placeholder="Top Title" value="`+s_top_title+`" name="components[`+_rand+`][slider][top_titles][]">
                        </div>
                        <div class="form-group pb-2">
                            <input type="text" class="form-control" placeholder="Main Title" value="`+s_title+`" name="components[`+_rand+`][slider][titles][]">
                        </div>
                        <div class="form-group pb-2">
                            <input type="text" class="form-control" placeholder="Description" value="`+s_desc+`" name="components[`+_rand+`][slider][desc][]">
                        </div>
                        <div class="row">
                            <div class="form-group pb-2 col-md-6">
                                <input type="text" class="form-control" placeholder="Button Text" value="`+s_btn_text+`" name="components[`+_rand+`][slider][btntext][]">
                            </div>
                            <div class="form-group pb-2 col-md-6">
                                <input type="text" class="form-control" placeholder="Button Link" value="`+s_btn_link+`" name="components[`+_rand+`][slider][btnlink][]">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="image-placeholder" data-input="slideImg-`+um+`-`+_rand+`" data-preview="slider-p-`+um+`-`+_rand+`" id="slider-p-`+um+`-`+_rand+`">
                                <img src="`+s_img+`" class="img-responsive img-selection img-thumbnail img-thumbnail-set">
                            </div>
                            <input type="hidden" id="slideImg-`+um+`-`+_rand+`" value="`+s_img+`" name="components[`+_rand+`][slider][images][]">
                            <strong>Image Size: <small>1900 × 500 pixels</small></strong>
                        </div>
                    </div>
                </td>
            </tr>
        `);
        $(".slide-fields").val('');
        $("#slider-modal-"+_rand).modal('hide');
    });

    $(document).on('click', '.delete-slide', function(){
        $(this).parent().parent().parent().parent().parent().parent().parent().remove();
    });
    $(document).on('click', '.edit-slide', function () {
        $("#slideDetail-"+$(this).data('uid')).slideToggle();
    });

    /* Icon Input */
    var input_icon = '';
    $(document).on('click', '.icon-input a', function(){
        input_icon = $(this).parent().find('input');
        $("#icons-modal").modal('show');
    });
    $(document).on('click', '.add-icon', function(){
        var icon_class = $(this).find('i').attr('class');
        input_icon.val(icon_class);
        $("#icons-modal").modal('hide');
    });
</script>

{{-- Breadcurm --}}
<script>
    $(document).on('click', '.addbreadcurm', function(){
        var rand = $(this).attr('data-key');
        var noofbreadcurm = $('#noofbreadcurm'+rand).val();
        for (i = 1; i <= noofbreadcurm; i++) {
            var $count = Math.floor((Math.random() * 999) + 1);
            var html = ``;
            html = `
                <div class="form-group col-md-3 mt-1" style="border:solid 1px #eaeaea;border-radius:5px;padding:14px 0px 0px 0px;position:relative;display:inline-block;">
                    <button type="button" class="btn btn-sm btn-danger RemoveBreadcurm" style="position: absolute;right: 2px;top: 2px;font-size: 0.5rem;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <div class="form-group col-md-11 mb-1">
                        <input type="text" name="components[`+rand+`][banner][arr][`+$count+`][title]" class="form-control input-sm" placeholder="Title">
                    </div>

                    <div class="form-group col-md-11 mb-1">
                        <input type="text" name="components[`+rand+`][banner][arr][`+$count+`][link]" class="form-control input-sm" placeholder="Link">
                    </div>
                </div>
            `;
            $('#styleBreadcurm'+rand).append(html);
        }
    });

    $(document).on('click', '.RemoveBreadcurm', function(){
        $(this).parent().remove();
    });
</script>
{{-- Breadcurm --}}

{{-- Category --}}
<script>
    $(document).on('change', '.categoryParentC', function() {
        var rand = $(this).attr('data-rand');
        var id = $(this).val();
        $.ajax({
            url: '{{ url('get-sub-cate') }}',
            type: 'post',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                $('.subCates_' + rand).html(res.html);
                if (res.html != null) {
                    console.log($('.hideC_' + rand));
                    $('.hideC_' + rand).show();
                } else {
                    console.log('res.html');
                    $('.hideC_' + rand).hide();
                }
            },
        });
    });

    $(document).on('change', '.csc', function() {
        var val = $(this).val();
        var rand = $(this).attr('data-rand');
        if (val == 'state') {
            $('.state_' + rand).show();
            $('.city_' + rand).hide();
        } else if (val == 'city') {
            $('.city_' + rand).show();
            $('.state_' + rand).show();
        } else {
            $('.city_' + rand).hide();
            $('.state_' + rand).hide();
        }
    })

    $(document).on('change', '.countryChange', function() {
        var id = $(this).val();
        var rand = $(this).attr('data-rand');
        var location = 'state';
        var data = {
            _token: '{{ csrf_token() }}',
            id: id,
            type: 'fullSelect',
            location: location,
        };
        if (id != null && id != '') {
            $.ajax({
                url: '{!! url("get-states") !!}/'+id,
                type: 'GET',
                data: data,
                success: function(res) {
                    var html = `<option value="" selected disabled style="display:none">Select</option>`;
                    if (location == 'state') {
                        $.each(res, function(index, value) {
                            html += `<option value="${index}">${value}</option>`;
                        });
                        $('.state_select_' + rand).html(html);
                    }
                }
            })
        } else {
            $('.state_select_' + rand).html('');
        }
    });

    $(document).on('change', '.isCateT', function() {
        var val = $(this).val();
        var rand = $(this).attr('data-rand');
        if (val == 'category') {
            $('.ifCateT' + rand).show();
            $('.ifModelT' + rand).hide();
            $('.ifFaqT' + rand).hide();
            $('.ifBrandT' + rand).hide();
            $('.ifVehicleBodyT' + rand).hide();
            $('.ifMakeT' + rand).hide();
        } else if (val == 'makeModel') {
            $('.ifModelT' + rand).show();
            $('.ifCateT' + rand).hide();
            $('.ifFaqT' + rand).hide();
            $('.ifBrandT' + rand).hide();
            $('.ifVehicleBodyT' + rand).hide();
            $('.ifMakeT' + rand).hide();
        }else if (val == 'faqs') {
            $('.ifModelT' + rand).hide();
            $('.ifCateT' + rand).hide();
            $('.ifBrandT' + rand).hide();
            $('.ifFaqT' + rand).show();
            $('.ifVehicleBodyT' + rand).hide();
            $('.ifMakeT' + rand).hide();
        }else if (val == 'brand') {
            $('.ifModelT' + rand).hide();
            $('.ifCateT' + rand).hide();
            $('.ifBrandT' + rand).show();
            $('.ifFaqT' + rand).hide();
            $('.ifVehicleBodyT' + rand).hide();
            $('.ifMakeT' + rand).hide();
        }else if (val == 'vehicle_body') {
            $('.ifModelT' + rand).hide();
            $('.ifCateT' + rand).hide();
            $('.ifBrandT' + rand).hide();
            $('.ifFaqT' + rand).hide();
            $('.ifVehicleBodyT' + rand).show();
            $('.ifMakeT' + rand).hide();
        } else if (val == 'make') {
            $('.ifModelT' + rand).hide();
            $('.ifCateT' + rand).hide();
            $('.ifBrandT' + rand).hide();
            $('.ifFaqT' + rand).hide();
            $('.ifVehicleBodyT' + rand).hide();
            $('.ifMakeT' + rand).show();
        }else {
            $('.ifModelT' + rand).hide();
            $('.ifCateT' + rand).hide();
            $('.ifBrandT' + rand).hide();
            $('.ifFaqT' + rand).hide();
            $('.ifVehicleBodyT' + rand).hide();
            $('.ifMakeT' + rand).hide();
        }
    });
</script>
{{-- Category --}}

