@extends("front.blog._layout.layout")

@section("seo_title", $tag->name)

@section("post_content")
<!-- Latest Posts -->
<main class="posts-listing col-lg-8"> 
    <div class="container">
        <h2 class="mb-3">@lang("Tag") "{{$tag->name}}"</h2>
        @include("front.blog._layout.partials.post_content")
    </div>
</main>
@endsection

