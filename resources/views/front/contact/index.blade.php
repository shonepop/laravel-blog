@extends("front._layout.layout")

@section("seo_title", __("Contact Page"))

@section("recaptcha")
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@section("content")
<!-- Hero Section -->
<section style="background: url({{url('/themes/front/img/hero.jpg')}}); background-size: cover; background-position: center center" class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>@lang("Have an interesting news or idea? Don't hesitate to contact us!")</h1>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="col-lg-8"> 
            <div class="container">
                <form action="{{route('front.contact.send_message')}}" method="post" class="commenting-form" id="contact-form">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input 
                                name="name"
                                value="{{old('name')}}"
                                type="text" 
                                placeholder="Your Name" 
                                class="form-control @if($errors->has('name')) is-invalid @endif">
                            @include("front._layout.partials.form_errors", ["fieldName" => "name"])
                        </div>
                        <div class="form-group col-md-6">
                            <input 
                                name="email"
                                value="{{old('email')}}"
                                type="email" 
                                placeholder="Email Address (will not be published)" 
                                class="form-control @if($errors->has('email')) is-invalid @endif">
                            @include("front._layout.partials.form_errors", ["fieldName" => "email"])
                        </div>
                        <div class="form-group col-md-12">
                            <textarea 
                                name="message"
                                placeholder="Type your message" 
                                class="form-control @if($errors->has('message')) is-invalid @endif"
                                rows="20">{{old('message')}}</textarea>
                            @include("front._layout.partials.form_errors", ["fieldName" => "message"])
                        </div>
                        <div class="g-recaptcha" data-sitekey="{{config('recaptcha.api_site_key')}}" style="margin-top:20px;flex: 1 0 100%;padding-left:15px"></div>
                        <div style="flex: 1 0 100%; margin-bottom:20px; color:red;padding-left:15px">
                            @if ($errors->has('g-recaptcha-response'))
                            <strong>@lang("reCaptcha must be checked!")</strong>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-secondary">@lang("Submit Your Message")</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        <aside class="col-lg-4">
            <!-- Widget [Contact Widget]-->
            <div class="widget categories">
                <header>
                    <h3 class="h6">@lang("Contact Info")</h3>
                    <div class="item d-flex justify-content-between">
                        <span>@lang("15 Yemen Road, Yemen")</span>
                        <span><i class="fa fa-map-marker"></i></span>
                    </div>
                    <div class="item d-flex justify-content-between">
                        <span>@lang("(020) 123 456 789")</span>
                        <span><i class="fa fa-phone"></i></span>
                    </div>
                    <div class="item d-flex justify-content-between">
                        <span>@lang("info@company.com")</span>
                        <span><i class="fa fa-envelope"></i></span>
                    </div>
                </header>

            </div>
            <div class="widget latest-posts">
                <header>
                    <h3 class="h6">@lang("Latest Posts")</h3>
                </header>
                <div class="blog-posts">
                    @foreach($latestPosts as $post)
                    <a href="{{$post->getFrontUrl()}}">
                        <div class="item d-flex align-items-center">
                            <div class="image">
                                <img src="{{$post->getPhotoThumbUrl()}}" alt="..." class="img-fluid">
                            </div>
                            <div class="title"><strong>{{$post->title}}</strong>
                                <div class="d-flex align-items-center">
                                    <div class="views"><i class="icon-eye"></i> 
                                        {{$post->visit_count}}
                                    </div>
                                    <div class="comments"><i class="icon-comment"></i>
                                        {{$post->comments->where("status", App\Models\Comment::STATUS_ENABLED)->count()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection

@push("footer_javascript")
<!-- jquery-validation -->
<script src="{{url('../themes/admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{url('../themes/admin/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script>
$("#contact-form").validate({
    rules: {
        "name": {
            required: true,
            maxlength: 255
        },
        "email": {
            required: true,
            email: true,
            maxlength: 255
        },
        "message": {
            required: true,
            maxlength: 2500
        }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});
</script>
@endpush