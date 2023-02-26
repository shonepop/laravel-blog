<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Post extends Model {

    use HasFactory;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const POST_IMPORTANT = 1;
    const POST_REGULAR = 0;

    //mapped to table blog_posts
    protected $table = "blog_posts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["status", "photo", "post_category_id", "title", "author_id", "author_photo",
        "author_name", "visit_count", "description", "details", "index_page"];

//Relation belongsTo()
    public function postCategory() {
        return $this->belongsTo(
                        PostCategory::class,
                        "post_category_id",
                        "id"
        );
    }

//Relation belongsToMany()
    public function tags() {
        return $this->belongsToMany(
                        Tag::class,
                        "post_tags",
                        "post_id",
                        "tag_id"
        );
    }

//Relation hasMany()
    public function comments() {
        return $this->hasMany(
                        Comment::class,
                        "post_id",
                        "id"
        );
    }

    /**
     * Scope a query only to include latest blog posts with the enabled status and marked as important.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeGetImportantPosts() {
        return $this->query()
                        ->with(["postCategory", "comments"])
                        ->where("status", "=", self::STATUS_ENABLED)
                        ->where("index_page", "=", self::POST_IMPORTANT)
                        ->take(3)
                        ->latest()
                        ->get();
    }

    /**
     * Scope a query only to include 12 latest blog posts with the enabled status.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeGetLatestPosts() {
        return $this->query()
                        ->with("postCategory")
                        ->where("status", "=", self::STATUS_ENABLED)
                        ->take(12)
                        ->latest()
                        ->get();
    }

    /**
     * Scope a query only to include the 3 most visited blog posts in sidebar.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeSidebarLatestPosts() {
        return $this->query()
                        ->with("comments")
                        ->where("status", self::STATUS_ENABLED)
                        ->take(3)
                        ->latest("visit_count")
                        ->get();
    }

    /**
     * Scope a query to include all blog posts with the enabled status.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeGetBlogPosts() {
        return $this->query()
                        ->with(["postCategory", "comments"])
                        ->where("status", self::STATUS_ENABLED);
    }

    /**
     * Scope a query only to include the last 3 created blog posts.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeFooterBlogPosts() {
        return $this->query()
                        ->where("status", self::STATUS_ENABLED)
                        ->take(3)
                        ->latest()
                        ->get();
    }

    /**
     * Scope a query to include previous blog post.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getPreviousPost() {
        return $this->query()
                        ->where('created_at', '<', $this->created_at)
                        ->where("status", self::STATUS_ENABLED)
                        ->orderBy("created_at", "DESC")
                        ->first();
    }

    /**
     * Scope a query to include previous blog post.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getNextPost() {
        return $this->query()
                        ->where('created_at', '>', $this->created_at)
                        ->where("status", self::STATUS_ENABLED)
                        ->orderBy("created_at", "ASC")
                        ->first();
    }

    /**
     * Scope a query to include current blog post.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getCurrentPost() {
        return $this->query()
                        ->where('created_at', '=', $this->created_at)
                        ->where("status", self::STATUS_ENABLED)
                        ->first();
    }

    /**
     * Scope a query to select blog posts that match the search term.
     * 
     * @param string $searchTerm
     * @return Illuminate\Database\Eloquent\Collection 
     */
    public function getSearchResults($searchTerm) {
        return $this->query()
                        ->with(["postCategory", "comments"])
                        ->where("status", self::STATUS_ENABLED)
                        ->join("post_categories", "blog_posts.post_category_id", "=", "post_categories.id")
                        ->select(["blog_posts.*", "post_categories.name"])
                        ->where(function ($subquery) use ($searchTerm) {
                            $subquery->orWhere("blog_posts.title", "LIKE", "%" . $searchTerm . "%")
                            ->orWhere("blog_posts.description", "LIKE", "%" . $searchTerm . "%")
                            ->orWhere("post_categories.name", "LIKE", "%" . $searchTerm . "%");
                        })
                        ->paginate(6);
    }

    /**
     * Set the post category id to 1 for blog posts that don't have a category.
     * 
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function setPostCategoryId($id) {
        return $this->query()
                        ->where("post_category_id", $id)
                        ->update(['post_category_id' => 1]);
    }

    /**
     * Scope a query to select blog posts for datatable.
     * 
     * @return Illuminate\Database\Eloquent\Collection 
     */
    public function getDatatablePosts() {
        return $this->query()
                        ->with(["postCategory", "tags"])
                        ->join("post_categories", "blog_posts.post_category_id", "=", "post_categories.id")
                        ->select(["blog_posts.*", "post_categories.name AS post_category_name"])
                        ->withCount(["comments"]);
    }

    /**
     * Check if the blog post is marked as important.
     * 
     * @return bool
     */
    public function isImportant() {
        return $this->index_page == self::POST_IMPORTANT;
    }

    /**
     * Check if the blog post is marked as regular.
     * 
     * @return bool
     */
    public function isRegular() {
        return $this->index_page == self::POST_REGULAR;
    }

    /**
     * Check if the blog post status is enabled.
     * 
     * @return bool
     */
    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    /**
     * Check if the blog post status is disabled.
     * 
     * @return bool
     */
    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

    /**
     * Display a single blog post page for a given id.
     * 
     * @return Illuminate\Support\Facades\Route
     */
    public function getFrontUrl() {
        return route("front.blog.post", [
            "post" => $this->id,
            "seoSlug" => \Str::slug($this->title),
        ]);
    }

    /**
     * Return a cover photo of the blog post.
     * 
     * @return url
     */
    public function getPhotoUrl() {

        if ($this->photo) {
            return url("/storage/posts/" . $this->photo);
        }

        return url('/themes/front/img/gallery-1.jpg');
    }

    /**
     * Return a thumb version of the blog post cover photo.
     * 
     * @return url
     */
    public function getPhotoThumbUrl() {

        if ($this->photo) {
            return url("/storage/posts/thumbs/" . $this->photo);
        }

        return url('/themes/front/img/small-thumbnail-1.jpg');
    }

    /**
     * Display a page with posts belonging to the specific author.
     * 
     * @return Illuminate\Support\Facades\Route
     */
    public function getAuthorFrontUrl() {

        return route("front.blog.author", [
            "post" => $this->id,
            "seoSlug" => \Str::slug($this->author_name)
        ]);
    }

    /**
     * Get a photo from the author of the post.
     * 
     * @return url
     */
    public function getAuthorPhoto() {

        if ($this->author_photo) {

            $photoFilePath = public_path("/storage/users/" . $this->author_photo);

            if (!is_file($photoFilePath)) {
                return url('/themes/front/img/avatar-1.jpg');
            }
            return url("/storage/users/" . $this->author_photo);
        }

        return url('/themes/front/img/avatar-1.jpg');
    }

    /**
     * Function converting date format to combine number and text presentation 
     * in the form of how much time has passed.
     * 
     * @param int $time
     * @return mixed
     */
    protected function get_time_ago($time) {
        $time_difference = time() - $time;

        if ($time_difference < 1) {
            return 'less than 1 second ago';
        }
        $condition = array(12 * 30 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;

            if ($d >= 1) {
                $t = round($d);
                return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }

    /**
     * Function converting date of when blog post is created to how long time was passed.
     * 
     * @return mixed
     */
    public function getTimeAgo() {
        return $this->get_time_ago(strtotime($this->created_at));
    }

    /**
     * Count individually blog post visit.
     * 
     * @return int
     */
    public function visitCount() {
        $this->visit_count++;
        $this->save();
        return $this->visit_count;
    }

    /**
     * Delete the cover photo of the blog post.
     * 
     * @return $this
     */
    public function deletePhoto() {
        if (!$this->photo) {
        //if photo doesn't exists
            return $this;
        }

        $photoFilePath = public_path("/storage/posts/" . $this->photo);

        //check if photo file exists on disc
        if (!is_file($photoFilePath)) {
            return $this;
        }
        //delete photo file
        unlink($photoFilePath);

        $photoFileThumbPath = public_path("/storage/posts/thumbs/" . $this->photo);

        //check if thumb photo file exists on disc
        if (!is_file($photoFileThumbPath)) {
            return $this;
        }
        //delete thumb photo file
        unlink($photoFileThumbPath);

        //fluent interface
        return $this;
    }

}
