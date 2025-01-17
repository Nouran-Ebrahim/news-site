<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory;
    use Sluggable;
    protected $guarded = [];

    protected $appends = ['status_name'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function posts(){
        return $this->hasMany(Post::class,'category_id');
    }

    public function getStatusNameAttribute($value)
    {
        if ($this->status==1) {
            return 'Active';
        }else{
            return 'Inactive';
        }

    }

}
