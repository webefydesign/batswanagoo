<section class="populars">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="colbanner">
                    <img src="{{url(($meta['img'])??'#')}}" alt="{{ ($meta['img_alt'])??'' }}">
                    <div class="coltext">
                        <h2>{{($meta['title'])??""}}</h2>
                        @if(isset($meta['btn_text']))
                        <a href="{{($meta['btn_link'])??'#'}}">{{$meta['btn_text']}}</a>
                        @endif
                    </div>
                </div>
            </div><!-- sm6 -->
            <div class="col-sm-6">
                <div class="textBanner">
                    <h2>{{($meta['ptitle'])??''}}</h2>
                    {!! ($meta['editor'])??'' !!}

                </div>
            </div><!-- sm6 -->
        </div>
    </div>
</section>
