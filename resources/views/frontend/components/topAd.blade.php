<section class="hiw_sec-6">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="area_ek">
                    <h4>{{ $meta['heading'] }}</h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bpstf_image_w">
                    <img src="{{ $meta['image'] }}" alt="{{ ($meta['img_alt'])??'' }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="bpsta_outer">
                    {!! $meta['description'] !!}
                    @if($meta['btn_txt'])<a href="{{ ($meta['btn_link'])??'#' }}" class="try_btn">{{ $meta['btn_txt'] }}</a>@endif
                </div>
            </div>
        </div>
    </div>
</section>
