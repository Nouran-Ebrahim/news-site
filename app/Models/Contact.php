<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['status_name'];
    public function getStatusNameAttribute($value)
    {
        if ($this->status==1) {
            return 'Read';
        }else{
            return 'Un read';
        }

    }

}
