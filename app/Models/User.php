<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;

class User extends Authenticatable {

    use HasApiTokens,
        HasFactory,
        Notifiable;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    public function isDisabled() {
        return $this->status == self::STATUS_DISABLED;
    }

    public function getPhotoUrl() {

        if ($this->photo) {
            return url("/storage/users/" . $this->photo);
        }

        return url('/themes/front/img/avatar-1.jpg');
    }

    public function deletePhoto() {
        if (!$this->photo) {
            return $this;
        }

        $photoPath = public_path('/storage/users/' . $this->photo);

        if (is_file($photoPath)) {
            unlink($photoPath);
        }

        return $this;
    }  

}
