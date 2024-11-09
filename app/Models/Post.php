<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
    use Sluggable;
    protected $guarded = [];
    protected $appends = ['status_name'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function getStatusNameAttribute($value)
    {
        if ($this->status==1) {
            return 'Active';
        }else{
            return 'Inactive';
        }

    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'post_id');
    }
    //local scope excute when i call it but global excute automaticly
    //local scope Active
    public function scopeActive($query){
        $query->where('status',1);
    }
}
