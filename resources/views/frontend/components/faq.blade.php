<div class="m-container">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1> {{ $meta['faq_heading'] ?? '' }} </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-faq">
                    <form action="" method="GET">
                        <div class="form-inns">
                            <input type="text" id="search-input" name="search"
                                placeholder="Search in Frequently Asked Questions"
                                value="{{ $_GET['search'] ?? null }}">
                            <button type="submit" id="search-btn"><img
                                    src="{{ asset('assets_frontend/img/icon/search.png') }}"></button>
                        </div>
                    </form>
                </div>
                @php $i = 0 @endphp
                @foreach (getFaqPosts($_GET['search'] ?? null) as $key => $values)
                    <div class="w-widgets">
                        <h3>{{ $key }}</h3>
                        <div class="widget-f">
                            <ul class="todo-links">
                                @foreach ($values as $value)
                                    <li><a data-name="faq{{ $value->id }}" class="{{ $i == 0 ? 'active' : '' }}">{{ $value->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div><!-- w-widgetS -->
                    @php $i += 1 @endphp
                @endforeach
            </div><!-- sm5 -->
            <div class="col-sm-7">
                <div class="faq-content">
                    @foreach (getSalonegooFaqs() as $key => $values)
                        <div class="faq-pane {{ $key == 0 ? 'active' : '' }}" id="faq{{ $values->id }}"
                            role="tabpanel">
                            <h2>{{ $values->title }}</h2>
                            {!! $values->description !!}
                        </div><!-- faq-pane -->
                    @endforeach
                </div>
            </div><!-- sm7 -->
        </div><!-- row -->
    </div>


</div><!-- m-container -->

@push('push_script')
    <script>
        $('.todo-links a').on('click', function() {
            datasText2 = $(this).attr('data-name');
            console.log(datasText2);
            $('.faq-content .faq-pane').removeClass('active');
            $('#' + datasText2).addClass('active');
            //$("html, body").animate({ scrollTop: $('#'+datasText).offset().top - 100}, 1000);
        });
    </script>
@endpush
