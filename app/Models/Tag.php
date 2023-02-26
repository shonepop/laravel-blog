<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    use HasFactory;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    //mapped to table tags
    protected $table = "tags";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["name"];

    //Relation belongsToMany()
    public function posts() {
        return $this->belongsToMany(
                        Post::class,
                        "post_tags",
                        "tag_id",
                        "post_id"
        );
    }

    /**
     * Display a page with posts belonging to the tag with a given id.
     * 
     * @return Illuminate\Support\Facades\Route
     */
    public function getFrontUrl() {
        return route("front.blog.tag", [
            "tag" => $this->id,
            "seoSlug" => \Str::slug($this->name),
        ]);
    }

    /**
     * Scope a query to include all blog post tags in sidebar.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeSidebarTags() {
        return $this->query()
                        ->withCount(["posts" => function ($subquery) {
                                $subquery->where("status", self::STATUS_ENABLED);
                            }])
                        ->orderBy("posts_count", "DESC")
                        ->get();
    }

}
