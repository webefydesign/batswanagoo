<style>
    .card{
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 4px -2px #18274b14, 0 2px 4px -2px #18274b1f;
        margin-bottom: 16px;
        padding: 16px;
    }

    .card-header{border-bottom:0px;}

    .accordionTitle{
        align-items: center;
        color: #28363e;
        cursor: pointer;
        display: flex;
        font-size: 16px;
        font-weight: 700;
        justify-content: space-between;
        letter-spacing: .15px;
        line-height: 24px;
        text-decoration: none;
    }
</style>

<div class="m-container" style="margin-top:0px;">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="b-safety-tips__subtitle" style="font-size: 22px;font-style: normal;font-weight: 500;margin-bottom: 16px;">{{($meta['title'])??''}}</h2>
            </div>
        </div>

        @if(isset($meta['tips1']) && count($meta['tips1'])>0)
            <div class="row">
                    <div class="col-md-12">
                        <div class="accordion" id="accordionExample">
                            @foreach(getSafetiesById($meta['tips1']) as $key => $value)
                                <div class="card">
                                    <div class="card-header" id="tipshead{{$key}}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link accordionTitle" type="button" data-toggle="collapse" data-target="#tips{{$key}}" aria-expanded="true" aria-controls="tips{{$key}}">
                                                {!! ($value['title'])??'' !!}
                                            </button>
                                        </h2>
                                    </div>
    
                                    <div id="tips{{$key}}" class="collapse show" aria-labelledby="tipshead{{$key}}" data-parent="#accordionExample">
                                        <div class="card-body">
                                        {!! ($value['description'])??'' !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
            </div>
        @endif
        <!-- sm7 -->
    </div><!-- row -->
</div>
