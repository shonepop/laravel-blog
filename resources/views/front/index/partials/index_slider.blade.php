<!-- Hero Section - Slider x3 -->
<div id="index-slider" class="owl-carousel">
    @foreach($sliderPosts as $sliderPost)
    <section style="background: url( {{$sliderPost->getPhotoUrl()}} ); background-size: cover; background-position: center center" class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1>{{ $sliderPost->title }}</h1>
                    <a href="{{ $sliderPost->button_url }}" class="hero-link">
                        {{ $sliderPost->button_name }}
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endforeach
</div>

<!-- /storage/postSlider/{{$sliderPost->photo}} -->