<section class="subs">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="sub-tit text-left mb-4">
                    <div class="sp-t">
                        <div>
                            <h2>{{($meta['faq_heading'])??''}}</h2>
                        </div>
                    </div>
                </div>
                <div class="how-to-coll">
                    @if(isset($meta['category']))
                    @php $categories = categoriesById($meta['category']); @endphp
                    <div class="accordion" id="faq">
                        @foreach($categories as $category)
                            @if(count($category->faqs)>0)
                                @foreach ($category->faqs as $fk => $faq)
                                    <div class="card">
                                        <div class="card-header" id="faqhead{{$fk}}">
                                            <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq{{$fk}}"
                                                aria-expanded="true" aria-controls="faq{{$fk}}">{{($faq['title'])??''}}</a>
                                        </div>
                                        <div id="faq{{$fk}}" class="collapse @if($fk==0) show @endif" aria-labelledby="faqhead{{$fk}}" data-parent="#faq">
                                            <div class="card-body">
                                                {!! ($faq['description'])??'' !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            <!-- sm6 -->
            <div class="col-sm-6">
                <div class="col-gt">
                    <div class="sub-tit text-left mb-4">
                        <div class="sp-t">
                            <div>
                                @if(isset($meta['heading']))<h2>{{($meta['heading'])??''}}</h2>@endif
                                @if(isset($meta['text'])){!! ($meta['text'])??'' !!}@endif
                                @if(isset($meta['img']))<img src="{{url(($meta['img'])??'#')}}" alt="{{ ($meta['img_alt'])??'' }}">@endif
                                @if(isset($meta['btn_txt'])) <a href="{{url(($meta['btn_link'])??'#')}}">{{ ($meta['btn_txt'])??'' }}</a> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sm6 -->
        </div>
        <!-- row -->
    </div>
</section>
