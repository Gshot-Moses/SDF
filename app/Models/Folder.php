<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    const DOCUMENTS = 1;
    const MEDIA = 2;
    const BRANDBOOK = 3; 

    public function files() {
        return $this->hasMany(File::class);
    }
}
