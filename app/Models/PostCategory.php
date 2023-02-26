<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model {

    use HasFactory;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    //mapped to table post_categories
    protected $table = "post_categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["name", "description", "priority"];

    //Relation hasMany()
    public function posts() {
        return $this->hasMany(
                        Post::class,
                        "post_category_id",
                        "id"
        );
    }

    /**
     * Display a page with posts belonging to the category with a given id.
     * 
     * @return Illuminate\Support\Facades\Route
     */
    public function getFrontUrl() {

        return route("front.blog.category", [
            "category" => $this->id,
            "seoSlug" => \Str::slug($this->name),
        ]);
    }

    /**
     * Scope a query to include all blog post categories in sidebar.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeSidebarPostCategories() {
        return $this->query()
                        ->withCount(["posts" => function ($query) {
                                $query->where("status", self::STATUS_ENABLED);
                            }])
                        ->orderBy("priority")
                        ->get();
    }

    /**
     * Scope a query only to include the last 4 created blog post categories.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeFooterPostCategories() {
        return $this->query()
                        ->orderBy("priority", "DESC")
                        ->limit(4)
                        ->get();
    }

    /**
     * Scope a query to include all blog post categories.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getPostCategories() {
        return $this->query()
                        ->orderBy("priority")
                        ->get();
    }

    /**
     * Scope a query to include the post category with the highest priority.
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getCategoryWithHighestPriority() {
        return $this->query()
                        ->orderBy("priority", "DESC")
                        ->first();
    }

}
