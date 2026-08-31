@push('push_css')
<style>
    .stickyImg {
        position: sticky;
        position: -webkit-sticky;
        margin-top: 0;
        top: 90px;
        border: 2px solid #036dbf;
        border-radius: 10px;
    }
</style>
@endpush
<div class="m-container">
    <section class="sellPoints" id="{{ $meta['sectionID'] }}">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 {{ isset($meta['image_position']) == 1 ? 'order-2' : '' }}">
                    <img src="{{ $meta['img'] }}" alt="{{ ($meta['img_alt'])??'' }}" class="stickyImg">
                </div>
                <div class="col-sm-6">
                    <div class="w--50">
                        <h2>{{ $meta['title'] }}</h2>
                        {!! $meta['desc'] !!}
                        @if (isset($meta['btn_txt']))
                            <div class="s--btn">
                                <a href="{{ $meta['btn_link'] }}">{{ $meta['btn_txt'] }}</a>
                            </div>
                        @endif

                    </div>
                </div><!-- sm6 -->
            </div>
        </div>
    </section>
</div>
