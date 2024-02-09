<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\profile;

class Specialty extends Model
{
    protected $fillable = [
        'name',
    ];

    public function profiles(){
        return $this->belongsToMany(Profile::class);
    }

    use HasFactory;
}
