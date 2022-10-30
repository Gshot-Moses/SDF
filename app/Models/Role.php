<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const MEMBER = 1;
    const ADMIN = 2;

    public function users() {
        return $this->hasMany(User::class);
    }
}
