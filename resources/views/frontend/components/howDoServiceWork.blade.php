<section class="all-list-bre brd-1">
    <div class="container sec-all-list-bre">
        <div class="row">

        </div>
    </div>
</section>
<section class="hiw_sec">
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="area_ek">
                    <h4>{{ $meta['ftitle'] ?? '' }}</h4>
                    <div class="hdpsw_area">
                        <img src="{{ url(($meta['img'])??'#') }}" alt="{{ ($meta['img_alt'])??'' }}">
                        <div class="hdpsw_text">
                            {!! $meta['description'] ?? '' !!}
                            @if(isset($meta['btn_text'])) <a href="{{ ($meta['btn_link'])??'#' }}">{{ ($meta['btn_text'])??'' }}</a> @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</section>

<section class="hiw_sec-2">
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="b-ps-about-cards-wrapper">
                    <div class="b-ps-about-card" style="background-color: #006ebf;">
                        {!! $meta['topAdsPromo'] ?? '' !!}
                    </div>
                    <div class="b-ps-about-card" style="background-color: #1eaf38;">
                        {!! $meta['boostPlans'] ?? '' !!}
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</section>
