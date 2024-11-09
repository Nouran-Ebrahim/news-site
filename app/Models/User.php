<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded = [];
    protected $appends = ['image_path', 'status_name'];


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
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    // public function getImageAttribute($value)
    // {
    //     if ($value != null && $value != '') {
    //         return asset('uploads/users/' . $value);
    //     }
    //     return $value;
    // }
    public function getImagePathAttribute($value)
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image; // Return the image URL if valid
        }

        return url('uploads/users/' . $this->image);

    }
    public function getStatusNameAttribute($value)
    {
        if ($this->status == 1) {
            return 'Active';
        } else {
            return 'Inactive';
        }

    }
}
