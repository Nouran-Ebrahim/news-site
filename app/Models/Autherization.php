<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autherization extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getPermessionsAttribute($permssions){
        return json_decode($permssions);//to convert object to array
    }
    public function admins(){
        return $this->hasMany(Admin::class);
    }


}
