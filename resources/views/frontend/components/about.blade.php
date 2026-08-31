<div class="m-container">
    <section class="contentS">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 align-self-center">
                    <div class="w--50">
                        @if($meta['title'])<h2>{{ ($meta['title'])??'' }}</h2>@endif
                        @if($meta['desc'])<p>{{ ($meta['desc'])??'' }}</p>@endif
                        <div class="tabsC">
                            <span>Table of contents</span>
                            <ul class="toc-list">
                                <li><a data-name="{{ ($meta['section1ID'])??'' }}"
                                        href="javascript:void(0);">{{ ($meta['section1'])??'' }}<img
                                            src="{{ asset('assets_frontend/img/down-arrow.png') }}"></a></li>
                                <li><a data-name="{{ ($meta['section2ID'])??'' }}"
                                        href="javascript:void(0);">{{ ($meta['section2'])??'' }}<img
                                            src="{{ asset('assets_frontend/img/down-arrow.png') }}"></a></li>
                                <li><a data-name="{{ ($meta['section3ID'])??'' }}"
                                        href="javascript:void(0);">{{ ($meta['section3'])??'' }} <img
                                            src="{{ asset('assets_frontend/img/down-arrow.png') }}"></a></li>
                                <li><a data-name="{{ ($meta['section4ID'])??'' }}"
                                        href="javascript:void(0);">{{ ($meta['section4'])??'' }}<img
                                            src="{{ asset('assets_frontend/img/down-arrow.png') }}"></a></li>
                            </ul>
                        </div>
                    </div>
                </div><!-- sm6 -->
                <div class="col-sm-6 align-self-center">
                    <img src="{{ url(($meta['img'])??'#') }}">
                </div><!-- sm6 -->
            </div>
        </div>
    </section>
</div>
@push('push_script')
    <script type="text/javascript">
        $('.toc-list a').on('click', function() {
            datasText = $(this).attr('data-name');
            $("html, body").animate({
                scrollTop: $('#' + datasText).offset().top - 100
            }, 1000);
        });
    </script>
@endpush
