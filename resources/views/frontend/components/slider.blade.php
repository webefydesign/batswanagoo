@php $rand = rand(0, 999); @endphp
<!-- START -->
<section>
    <div id="demo{{$rand}}" class="carousel slide cate-sli caro-home" data-ride="carousel">
        <div class="carousel-inner">
            @if (isset($meta['id']) && getSlider($meta['id']) != null)
                @php $images = getSlider($meta['id'])['image']; @endphp
                @foreach ($images as $k => $img)
                    <div class="carousel-item {{ $k == 0 ? 'active' : '' }}" data-bs-interval="{{ 2000 + ($k + 1) * 1000 }}">
                        <img src="{{ url($img ?? '#') }}" class="d-block w-100" alt="...">
                    </div>
                @endforeach
            @endif
        </div>
        @if (isset($meta['id']) && getSlider($meta['id']) != null)
            <a class="carousel-control-prev" href="#" data-target="#demo{{$rand}}" data-slide="prev"> <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#" data-target="#demo{{$rand}}" data-slide="next"> <span class="carousel-control-next-icon"></span>
            </a>
        @endif
    </div>
 </section>
 <!--END-->
