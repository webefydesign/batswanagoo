<div class="m-container" style="margin-top:0px;">
    <div class="container">
        @isset($meta['title'])
        <div class="row">
            <div class="col-sm-12">
                <h1>{{($meta['title'])??''}}</h1>
            </div>
        </div>
        @endif

        <div class="row">

            <div class="col-sm-12">
                @if(isset($meta['tips1']) && count($meta['tips1'])>0)
                <div class="safe-content">
                    @isset($meta['title2'])
                    <h2>{{($meta['title2'])??''}}</h2>
                    @endisset
                    <ul class="gs-ul">
                        @foreach(getSafetiesById($meta['tips1']) as $key => $value)
                        <li>
                            <div class="gs-left">
                                <img src="{{url(($value['image'])??'#')}}">
                            </div>
                            <div class="gs-right">
                                <strong>{!! ($value['title'])??'' !!}</strong>
                                <p>{!! ($value['description'])??'' !!}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div><!-- faq-pane -->
                @endif

                @if(isset($meta['tips2']) && count($meta['tips2'])>0)
                <div class="safe-content">
                    @isset($meta['title3'])
                    <h2>{{($meta['title3'])??''}}</h2>
                    @endisset
                    <ul class="gs-ul-col">
                        @foreach(getSafetiesById($meta['tips2']) as $key => $value)
                        <li>
                            <div class="gs-left">
                                <img src="{{url(($value['image'])??'#')}}">
                            </div>
                            <div class="gs-right">
                                <strong>{!! ($value['title'])??'' !!}</strong>
                                <p>{!! ($value['description'])??'' !!}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div><!-- faq-pane -->
                @endif


            </div>

            {{--
            <div class="col-sm-3">
                <div class="alerts">
                    <h3><i class="glyphicon glyphicon-exclamation-sign h-width-16 h-orange"></i> {{($meta['error'])??''}}</h3>
                    <p>{!! ($meta['info'])??'' !!}</p>
                </div>
            </div>
            --}}
            <!-- sm3 -->


        </div><!-- sm7 -->
    </div><!-- row -->
</div>
