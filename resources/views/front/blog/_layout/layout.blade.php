@extends("front._layout.layout")

@section("content")
<div class="container">
    <div class="row">
        
        @yield("post_content")
        
        @include("front.blog._layout.partials.sidebar")
        
    </div>
</div>
@endsection