<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['logo_path', 'favicon_path'];

    public function getLogoPathAttribute($value)
    {
        if ($this->logo) {
            return url('uploads/settings/' . $this->logo);
        }

    }
    public function getFaviconPathAttribute($value)
    {
        if ($this->favicon) {
            return url('uploads/settings/' . $this->favicon);
        }

    }
}
