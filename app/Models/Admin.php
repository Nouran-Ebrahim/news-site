<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Log;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guarded = []; //must use fillable for security
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = ['status_name'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed' // to autmaticly has the password
    ];
    public function role()
    {
        return $this->belongsTo(Autherization::class, 'autherization_id');
    }
    public function getStatusNameAttribute($value)
    {
        if ($this->status == 1) {
            return 'Active';
        } else {
            return 'Inactive';
        }

    }
    public function hasAccess($permession)
    {
        $role = $this->role;
     
        foreach ($role->permessions as $permessionAdmin) {
            if ($permession == $permessionAdmin ?? false) {
                return true;
            }

        }
    }
}
