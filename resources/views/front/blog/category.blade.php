@extends("front.blog._layout.layout")

@section("seo_title", $category->name)
@section("seo_description", $category->description)

@section("post_content")
<!-- Latest Posts -->
<main class="posts-listing col-lg-8"> 
    <div class="container">
        <h2 class="mb-3">@lang("Category") "{{$category->name}}"</h2>

        @include("front.blog._layout.partials.post_content")
    </div>
</main>
@endsection

