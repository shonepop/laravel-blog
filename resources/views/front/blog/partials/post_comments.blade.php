<header>
    <h3 class="h6">@lang("Post Comments")
        <span class="no-of-comments">({{$postComments->count()}})</span>
    </h3>
</header>
@foreach($postComments as $postComment)
<div class="comment">
    <div class="comment-header d-flex justify-content-between">
        <div class="user d-flex align-items-center">
            <div class="image"><img src="{{$postComment->getCommentAuthorPhoto()}}" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title"><strong>{{$postComment->author_name}}</strong>
                <span class="date">{{ date("M Y",strtotime($postComment->created_at)) }}</span>
            </div>
        </div>
    </div>
    <div class="comment-body">
        <p>{{$postComment->description}}</p>
    </div>
</div>
@endforeach