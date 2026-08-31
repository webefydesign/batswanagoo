<!-- START -->
<section class="top-categoriesdiv">
    <div class="top-categories" style="padding:0px 0;">
        <div class="container">
            <div class="row">
                <div class="sub-tit">
                    <h2>{{($meta['title'])??''}}</h2>
                </div>
                <div class="col-md-12">
                    <div class="Wrap-top-categories">
                        @if(isset($meta['top']))
                            @foreach ($meta['top'] as $top)
                                <a href="{{url(($top['link'])??'#')}}">
                                    <div class="img-Wrap img-Wrap-car" style="background-color:{{($top['color'])??''}};">
                                        <img src="{{url(($top['image'])??'#')}}">
                                    </div>
                                    <span class="textWrap"> {{($top['title'])??''}}</span>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END -->
