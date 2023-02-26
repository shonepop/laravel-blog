<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSlider extends Model {

    use HasFactory;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    //mapped to table blog_post_slider
    protected $table = "blog_post_slider";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["status", "priority", "photo", "title", "button_name", "button_url"];

    /**
     * Scope a query only to include slider posts with the enabled status.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeGetSliderPosts() {
        return $this->query()
                        ->orderBy("priority", "ASC")
                        ->where("status", "=", self::STATUS_ENABLED)
                        ->get();
    }

    /**
     * Scope a query to include slider post with the highest priority.
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function scopeGetPostWithHighestPriority() {
        return $this->query()
                        ->orderBy("priority", "DESC")
                        ->first();
    }

    /**
     * Return a cover photo of the slider post.
     * 
     * @return url
     */
    public function getPhotoUrl() {

        if ($this->photo) {
            return url("/storage/postSlider/" . $this->photo);
        }

        return url('/themes/front/img/gallery-1.jpg');
    }

    /**
     * Check if the slider post status is enabled.
     * 
     * @return bool
     */
    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    /**
     * Check if the slider post status is disabled.
     * 
     * @return bool
     */
    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

    /**
     * Delete the cover photo of the slider post.
     * 
     * @return $this
     */
    public function deletePhoto() {
        if (!$this->photo) {
            //if photo doesn't exists
            return $this;
        }

        $photoPath = public_path('/storage/postSlider/' . $this->photo);

        //check if photo file exists on disc
        if (is_file($photoPath)) {
            //delete file
            unlink($photoPath);
        }

        //fluent interface
        return $this;
    }

}
