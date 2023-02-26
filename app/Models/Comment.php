<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    use HasFactory;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    //mapped to table post_comments
    protected $table = "post_comments";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["post_id", "status", "author_photo", "author_name", "author_email", "description"];

    //relation belongsTo()
    public function post() {
        return $this->belongsTo(
                        Post::class,
                        "post_id",
                        "id"
        );
    }

    /**
     * Get a photo from the author of the comment.
     * 
     * @return url
     */
    public function getCommentAuthorPhoto() {

        if ($this->author_photo) {
            return $this->author_photo;
        }

        return url('/themes/front/img/user.svg');
    }

    /**
     * Check if the comment status is enabled.
     * 
     * @return bool
     */
    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    /**
     * Check if the comment status is disabled.
     * 
     * @return bool
     */
    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

    /**
     * Display a single blog post for a given id.
     * 
     * @return Illuminate\Support\Facades\Route
     */
    public function getFrontUrl() {

        return route("front.blog.post", [
            "post" => $this->post_id,
        ]);
    }

}
