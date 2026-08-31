<section class="postss">
    <div class="container">
      <div class="row">
          @if(isset($meta['center']))
            <div class="col-sm-6 offset-sm-3">
              <div class="sub-tit">
                   @if(isset($meta['title'])) <h2>{{($meta['title'])??''}}</h2> @endif
                   {!! ($meta['desc'])??'' !!}
                </div>
            </div>
          @else
            <div class="col-sm-12">
              <div class="sub-tit" style="text-align:left;">
                   @if(isset($meta['title'])) <h2>{{($meta['title'])??''}}</h2> @endif
                   {!! ($meta['desc'])??'' !!}
                </div>
            </div>
          @endif
      </div>
    </div>
</section>
