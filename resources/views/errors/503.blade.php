@extends("front.blog._layout.layout")

@section("seo_title", __("Error 404"))
@section("seo_description", __("Error 404"))

@section("post_content")
<!-- Latest Posts -->
<main class="post blog-post col-lg-8">
    <section class="page_404">
        <div class="container">
            <div class="row">	
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1  text-center">
                        <div class="four_zero_four_bg">
                            <h1 class="text-center ">503 - Service Unavailable</h1>
                        </div>
                        <div class="contant_box_404">
                            <h3 class="h2">
                                Look like you're lost
                            </h3>
                            <p>the page you are looking for is not available!</p>
                            <a href="{{route('front.index.index')}}" class="link_404">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
