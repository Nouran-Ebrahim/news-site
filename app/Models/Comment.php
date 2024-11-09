<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['status_name'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function getStatusNameAttribute($value)
    {
        if ($this->status==1) {
            return 'Active';
        }else{
            return 'Inactive';
        }

    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
