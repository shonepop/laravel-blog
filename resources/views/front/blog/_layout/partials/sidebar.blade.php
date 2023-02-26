<aside class="col-lg-4">
    <!-- Widget [Search Bar Widget]-->
    <div class="widget search">
        <header>
            <h3 class="h6">@lang("Search the blog")</h3>
        </header>
        <form action="{{route('front.blog.search')}}" method="post" class="search-form">
            @csrf
            <div class="form-group">
                <input name="search" type="search" placeholder="What are you looking for?">                   
                <button type="submit" class="submit"><i class="icon-search"></i></button>
            </div>
        </form>
    </div>
    <!-- Widget [Latest Posts Widget]   3x     -->
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
    <!-- Widget [Categories Widget]-->
    <div class="widget categories">
        <header>
            <h3 class="h6">Categories</h3>
            @foreach($postCategories as $postCategory) 
        </header>
        <div class="item d-flex justify-content-between">
            <a href="{{$postCategory->getFrontUrl()}}">
                {{$postCategory->name}}
            </a>
            <span>{{$postCategory->posts_count}}</span>
        </div>
        @endforeach
    </div>
    <!-- Widget [Tags Cloud Widget]-->
    <div class="widget tags">       
        <header>
            <h3 class="h6">@lang("Tags")</h3>
        </header>
        <ul class="list-inline">
            @foreach($postTags as $postTag)
            <li class="list-inline-item">
                <a href="{{$postTag->getFrontUrl()}}" class="tag">
                    {{$postTag->name}}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</aside>

