<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Models\PostCategory;
use App\Models\Tag;

class BlogController extends Controller {

    /**
     * Display blog posts on the blog page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Post $post) {

        //get all blog posts
        $blogPosts = $post->getBlogPosts()->latest()->paginate(6);

        return view("front.blog.index", [
            "blogPosts" => $blogPosts,
        ]);
    }

    /**
     * Display single blog post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post $post
     * @param  string $seoSlug
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, Post $post, $seoSlug = null) {

        //if post is disabled show page 404
        if ($post->isDisabled()) {
            abort(404);
        }
        //get previous post
        $previousPost = $post->getPreviousPost();
        //get next post
        $nextPost = $post->getNextPost();

        //if the previous post doesn't exist stay at the current post
        if (!$previousPost) {
            $previousPost = $post->getCurrentPost();
        }
        //if the next post doesn't exist stay at the current post
        if (!$nextPost) {
            $nextPost = $post->getCurrentPost();
        }
        //if seo slug in url doesn't match the post title redirect to the original post
        if ($seoSlug != \Str::slug($post->title)) {
            return redirect()->away($post->getFrontUrl());
        }

        return view("front.blog.post", [
            "post" => $post,
            "previousPost" => $previousPost,
            "nextPost" => $nextPost,
        ]);
    }

    /**
     * Display posts that belongs to a given category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostCategory $category
     * @param  \App\Models\Post $post
     * @param  string $seoSlug
     * @return \Illuminate\Http\Response
     */
    public function category(Request $request, PostCategory $category, Post $post, $seoSlug = null) {

        //get all blog posts belonging to the category with a given id
        $blogPosts = $post->getBlogPosts()->where("post_category_id", $category->id)->paginate(6);

        //if seo slug in url doesn't match the category name redirect to the original post
        if ($seoSlug != \Str::slug($category->name)) {
            return redirect()->away($category->getFrontUrl());
        }

        return view("front.blog.category", [
            "category" => $category,
            "blogPosts" => $blogPosts,
        ]);
    }

    /**
     * Display posts that belongs to a given tag.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag $tag
     * @param  \App\Models\Post $post
     * @param  string $seoSlug
     * @return \Illuminate\Http\Response
     */
    public function tag(Request $request, Tag $tag, Post $post, $seoSlug = null) {

        $blogPosts = $post->getBlogPosts()
                ->whereHas("tags", function ($query) use ($tag) {
                    $query->where('tag_id', $tag->id);
                })
                ->paginate(6);

        //if seo slug in url doesn't match the tag name redirect to the original post
        if ($seoSlug != \Str::slug($tag->name)) {
            return redirect()->away($tag->getFrontUrl());
        }

        return view("front.blog.tag", [
            "tag" => $tag,
            "blogPosts" => $blogPosts,
        ]);
    }

    /**
     * Display post comments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comments(Request $request) {

        //scope a query to include comments for a specific blog post
        $postComments = Comment::query()
                ->where([
                    ["post_id", $request->query("id")],
                    ["status", Comment::STATUS_ENABLED]
                ])
                ->get();

        return view("front.blog.partials.post_comments", [
            "postComments" => $postComments
        ]);
    }

    /**
     * Add a new comment to the blog post.
     *
     * @param  \Illuminate\Http\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addComment(StoreCommentRequest $request) {
        
        //validate inputs, create and save new comment to the database
        Comment::create($request->validated());

        return response()->json([
                    "system_message" => __("Successfully added comment"),
        ]);
    }

    /**
     * Display posts from the specific author.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post $post
     * @param  string $seoSlug
     * @return \Illuminate\Http\Response
     */
    public function author(Request $request, Post $post, $seoSlug = null) {

        //get blog posts from the author with a given id
        $blogPosts = $post->getBlogPosts()->where("author_id", $post->author_id)->paginate(6);

        //if seo slug in url doesn't match the author name redirect to the original post
        if ($seoSlug != \Str::slug($post->author_name)) {
            return redirect()->away($post->getAuthorFrontUrl());
        }

        return view("front.blog.author", [
            "post" => $post,
            "blogPosts" => $blogPosts,
        ]);
    }

    /**
     * Search term as a result of a search input form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\Route
     */
    public function search(Request $request) {

        //validate search input term
        $searchFilter = $request->validate([
            "search" => ["required", "string", "max:255"]
        ]);

        //get a search term
        if ($request->has("search") && $request->get("search")) {
            $searchTerm = $request->get("search");
        }

        //redirect to route with search term
        return redirect()->route("front.blog.search_page", [
                    "searchTerm" => $searchTerm
        ]);
    }

    /**
     * Show search page with results from search term.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post $post
     * @param string $searchTerm 
     * @return \Illuminate\Http\Response
     */
    public function searchPage(Request $request, Post $post, $searchTerm) {

        //get blog posts that match the search term 
        $blogPosts = $post->getSearchResults($searchTerm);

        return view("front.blog.search_page", [
            "blogPosts" => $blogPosts,
            "searchTerm" => $searchTerm,
        ]);
    }

}
