<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['name'];


    public function post()
    {
        return $this->belongsTo(post::class, 'post_id');
    }

    public function getNameAttribute($value)
    {
        if ($this->path) {
            //assets in api not correct as it retern the path starting from uploads and not include the base url localhost:8000 but using url will be good in api and web
            return url('uploads/posts/' . $this->path);
        }

    }

}
