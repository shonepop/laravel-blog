@extends("front.blog._layout.layout")

@section("seo_title", $post->author_name)
@section("seo_image", $post->getAuthorPhoto())

@section("post_content")
<!-- Latest Posts -->
<main class="posts-listing col-lg-8"> 
    <div class="container">
        <h2 class="mb-3 author d-flex align-items-center flex-wrap">
            <div class="avatar">
                <img src="{{$post->getAuthorPhoto()}}" alt="..." class="img-fluid rounded-circle">
            </div>
            <div class="title">
                <span>@lang("Posts by author") "{{$post->author_name}}"</span>
            </div>
        </h2>

        @include("front.blog._layout.partials.post_content")
    </div>
</main>
@endsection

