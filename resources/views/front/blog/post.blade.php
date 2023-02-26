@extends("front.blog._layout.layout")

@section("seo_title", $post->title)
@section("seo_description", $post->description)
@section("seo_image", $post->getPhotoUrl())

@section("head_meta")
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section("post_content")
<!-- Latest Posts -->
<main class="post blog-post col-lg-8">
    <div class="container">
        <div class="post-single">
            <div class="post-thumbnail">
                <img src="{{$post->getPhotoUrl()}}" alt="..." class="img-fluid">
            </div>
            <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
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
                </div>
                <h1>{{ $post->title }}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                <div class="post-footer d-flex align-items-center flex-column flex-sm-row">
                    <a href="{{$post->getAuthorFrontUrl()}}" class="author d-flex align-items-center flex-wrap">
                        <div class="avatar"><img src="{{$post->getAuthorPhoto()}}" alt="..." class="img-fluid"></div>
                        <div class="title"><span>{{ $post->author_name }}</span></div>
                    </a>
                    <div class="d-flex align-items-center flex-wrap">       
                        <div class="date"><i class="icon-clock"></i>{{ $post->getTimeAgo() }}</div>
                        <div class="views"><i class="icon-eye"></i> {{ $post->visitCount() }}</div>
                        <div class="comments meta-last">
                            <a href="#post-comments"><i class="icon-comment"></i>
                                {{ $post->comments()->where("status", App\Models\Comment::STATUS_ENABLED)->count() }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="post-body">
                    <p class="lead">{{ $post->description }}</p>
                    {!! $post->details !!}
                </div>
                <div class="post-tags">
                    @foreach($post->tags as $tag)
                    <a href="{{$tag->getFrontUrl()}}" class="tag">
                        {{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                <div class="posts-nav d-flex justify-content-between align-items-stretch flex-column flex-md-row">


                    @if($previousPost->created_at < $post->created_at)
                    <a href="{{ route('front.blog.post', ['post' => $previousPost->id, 'seoSlug' => \Str::slug($previousPost->title)]) }}" class="prev-post text-left d-flex align-items-center">
                        <div class="icon prev"><i class="fa fa-angle-left"></i></div>
                        <div class="text"><strong class="text-primary">@lang("Previous Post")</strong>
                            <h6>{{ $previousPost->title }}</h6>                              
                        </div>
                        @else
                        <div></div>
                        @endif
                    </a>

                    @if($nextPost->created_at > $post->created_at)
                    <a href="{{ route('front.blog.post', ['post' => $nextPost->id, 'seoSlug' => \Str::slug($nextPost->title)]) }}" class="next-post text-right d-flex align-items-center justify-content-end">
                        <div class="text"><strong class="text-primary">@lang("Next Post")</strong>
                            <h6>{{ $nextPost->title }}</h6>
                        </div>
                        <div class="icon next"><i class="fa fa-angle-right">   </i></div>
                        @else
                        <div></div>
                        @endif
                    </a>

                </div>
                <div class="post-comments" id="post-comments">

                </div>
                <div class="add-comment">
                    <header>
                        <h3 class="h6">@lang("Leave a reply")</h3>
                    </header>
                    <form action="{{route('front.blog.add_comment')}}" method="post" class="commenting-form" id="post-comment-form">

                        <input type="hidden" name="post_id" value="">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input 
                                    type="text" 
                                    value="{{old('author_name')}}"
                                    name="author_name" 
                                    id="username" 
                                    placeholder="Name" 
                                    class="form-control @if($errors->has('author_name')) is-invalid @endif">
                                @include("front._layout.partials.form_errors", ["fieldName" => "author_name"])
                            </div>
                            <div class="form-group col-md-6">
                                <input 
                                    type="email"
                                    value="{{old('author_email')}}"
                                    name="author_email" 
                                    id="useremail" 
                                    placeholder="Email Address (will not be published)" 
                                    class="form-control @if($errors->has('author_email')) is-invalid @endif">
                                @include("front._layout.partials.form_errors", ["fieldName" => "author_email"])
                            </div>
                            <div class="form-group col-md-12">
                                <textarea 
                                    name="description" 
                                    id="usercomment" 
                                    placeholder="Type your comment" 
                                    class="form-control @if($errors->has('description')) is-invalid @endif">{{old('description')}}</textarea>
                                @include("front._layout.partials.form_errors", ["fieldName" => "description"])
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-secondary">@lang("Submit Comment")</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push("footer_javascript")
<!-- jquery-validation -->
<script src="{{url('../themes/admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{url('../themes/admin/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script>

function postCommentsRefresh() {

    let id = "{{$post->id}}";

    $.ajax({
        "url": "{{ route('front.blog.comments') }}",
        "type": "get",
        "data": {
            "id": id
        }
    }).done(function (response) {
        $("#post-comments").html(response);

    }).fail(function () {
        console.log("Error while reading comments");
    });
}


$("#post-comment-form").on("submit", function (e) {
    e.preventDefault();

    let id = "{{$post->id}}";
    $("#post-comment-form [name='post_id']").val(id);


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        "url": "{{ route('front.blog.add_comment') }}",
        "type": "post",
        "data": $(this).serialize()
    }).done(function (response) {
        toastr.success(response.system_message);
        postCommentsRefresh();
        $('#post-comment-form').find('input,textarea').val('');
    }).fail(function () {
        toastr.error('Error while adding comment');
    });
});

$("#post-comment-form").validate({
    rules: {
        "author_name": {
            required: true,
            maxlength: 255
        },
        "author_email": {
            required: true,
            maxlength: 255
        },
        "description": {
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

postCommentsRefresh();


</script>
@endpush