<div class="row">
    @foreach($blogPosts as $post)
    <div class="post col-xl-6">
        <div class="post-thumbnail">
            <a href="{{$post->getFrontUrl()}}">
                <img src="{{$post->getPhotoUrl()}}" alt="..." class="img-fluid">
            </a>
        </div>
        <div class="post-details">
            <div class="post-meta d-flex justify-content-between">
                <div class="date meta-last">{{ date("d M | Y",strtotime($post->created_at)) }}</div>
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
            </div><a href="{{$post->getFrontUrl()}}">
                <h3 class="h4">{{$post->title}}</h3></a>
            <p class="text-muted">{{$post->description}}</p>
            <footer class="post-footer d-flex align-items-center">
                <a href="{{$post->getAuthorFrontUrl()}}" class="author d-flex align-items-center flex-wrap">
                    <div class="avatar"><img src="{{$post->getAuthorPhoto()}}" alt="..." class="img-fluid"></div>
                    <div class="title"><span>{{$post->author_name}}</span></div></a>
                <div class="date"><i class="icon-clock"></i> {{$post->getTimeAgo()}}</div>
                <div class="comments meta-last"><i class="icon-comment"></i>
                    {{$post->comments->where("status", App\Models\Comment::STATUS_ENABLED)->count()}}
                </div>
            </footer>
        </div>
    </div>
    @endforeach
</div>
<!-- Pagination -->
<nav aria-label="Page navigation example">
    <ul class="pagination pagination-template d-flex justify-content-center">
        {{$blogPosts->links()}}
    </ul>
</nav>