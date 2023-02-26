@extends("front._layout.layout")

@section("content")

@push("head_css")
<!-- owl carousel 2 stylesheet-->
<link rel="stylesheet" href="{{url('/themes/front/plugins/owl-carousel2/assets/owl.carousel.min.css')}}" id="theme-stylesheet">
<link rel="stylesheet" href="{{url('/themes/front/plugins/owl-carousel2/assets/owl.theme.default.min.css')}}" id="theme-stylesheet">
@endpush

<!-- Hero Section - Slider x3 -->
@include("front.index.partials.index_slider")

<!-- Intro Section - Heading, Blog Post x3 -->
<section class="intro">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="h3">@lang("Some great intro here")</h2>
                <p class="text-big">@lang("Place a nice <strong>introduction</strong> here <strong>to catch reader's attention</strong>.")</p>
            </div>
        </div>
    </div>
</section>
<section class="featured-posts no-padding-top">
    <div class="container">
        @foreach($posts as $post)
        <!-- Post-->
        <div class="row d-flex align-items-stretch">
            <div class="text col-lg-7">
                <div class="text-inner d-flex align-items-center">
                    <div class="content">
                        <header class="post-header">
                            <div class="category">
                                @if(optional($post->postCategory)->id != 1)
                                <a href="{{optional($post->postCategory)->getFrontUrl()}}">
                                    {{ optional($post->postCategory)->name }}
                                </a>
                                @else
                                <a>
                                    {{ optional($post->postCategory)->name }}
                                </a>
                                @endif
                            </div>
                            <a href="{{ $post->getFrontUrl() }}">
                                <h2 class="h4">{{$post->title}}</h2></a>
                        </header>
                        <p>{{$post->description}}</p>
                        <footer class="post-footer d-flex align-items-center">
                            <a href="{{$post->getAuthorFrontUrl()}}" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="{{$post->getAuthorPhoto()}}" alt="..." class="img-fluid"></div>
                                <div class="title">
                                    <span>{{$post->author_name}}</span>
                                </div>
                            </a>
                            <div class="date"><i class="icon-clock"></i>
                                {{ $post->getTimeAgo() }}
                            </div>
                            <div class="comments"><i class="icon-comment"></i>
                                {{ $post->comments->where("status", App\Models\Comment::STATUS_ENABLED)->count() }}
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
            <div class="image col-lg-5"><img src="{{$post->getPhotoUrl()}}" alt="..."></div>
        </div>
        @endforeach
    </div>
</section>

<!-- Divider Section - Contact Us -->
<section style="background: url(/themes/front/img/divider-bg.jpg); background-size: cover; background-position: center bottom" class="divider">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h2>@lang("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua")</h2>
                <a href="{{route('front.contact.index')}}" class="hero-link">@lang("Contact Us")</a>
            </div>
        </div>
    </div>
</section>

<!-- Latest Posts - Blog Post x3 -->
<section class="latest-posts"> 
    <div class="container">
        <header> 
            <h2>@lang("Latest from the blog")</h2>
            <p class="text-big">@lang("Lorem ipsum dolor sit amet, consectetur adipisicing elit.")</p>
        </header>
        <div class="owl-carousel" id="latest-posts-slider">
            @foreach($latestPosts as $latestPost)
            <div class="post col-md-4">
                <div class="post-thumbnail">
                    <a href="{{$latestPost->getFrontUrl()}}">
                        <img src="{{$latestPost->getPhotoUrl()}}" alt="..." class="img-fluid">
                    </a>
                </div>
                <div class="post-details">
                    <div class="post-meta d-flex justify-content-between">
                        <div class="date">{{date("d M | Y", strtotime($latestPost->created_at))}}</div>
                        <div class="category">
                            @if(optional($latestPost->postCategory)->id != 1)
                        <a href="{{optional($latestPost->postCategory)->getFrontUrl()}}">
                            {{ optional($latestPost->postCategory)->name }}
                        </a>
                        @else
                        <a>
                            {{ optional($latestPost->postCategory)->name }}
                        </a>
                        @endif
                        </div>
                    </div><a href="{{$latestPost->getFrontUrl()}}">
                        <h3 class="h4">{{$latestPost->title}}</h3></a>
                    <p class="text-muted">{{$latestPost->description}}</p>
                </div>
            </div>   
            @endforeach
        </div>
    </div>
</section>

<!-- Gallery Section - Images x4 -->
<section class="gallery no-padding">    
    <div class="row">
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="img/gallery-1.jpg" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-1.jpg')}}" alt="gallery image alt 1" class="img-fluid" title="gallery image title 1">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="img/gallery-2.jpg" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-2.jpg')}}" alt="gallery image alt 2" class="img-fluid" title="gallery image title 2">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="img/gallery-3.jpg" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-3.jpg')}}" alt="gallery image alt 3" class="img-fluid" title="gallery image title 3">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="img/gallery-4.jpg" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-4.jpg')}}" alt="gallery image alt 4" class="img-fluid" title="gallery image title 4">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>

    </div>
</section>

@endsection

@push("footer_javascript")
<script src="{{url('/themes/front/plugins/owl-carousel2/owl.carousel.min.js')}}"></script>
<script>
$("#index-slider").owlCarousel({
    "items": 1,
    "loop": true,
    "autoplay": true,
    "autoplayHoverPause": true
});

$("#latest-posts-slider").owlCarousel({

    "items": 3,
    responsive: {
        //breakpoint from 0 and up
        0: {
            "items": 1,
        },
        // add as many breakpoints as desired , breakpoint from 480 up
        480: {
            "items": 1,
        },
        // breakpoint from 768 up
        768: {
            "items": 2,
        },
        992: {
            "items": 3,
        },
    },
    "loop": true,
    "autoplay": true,
    "autoplayHoverPause": true
});
</script>
@endpush