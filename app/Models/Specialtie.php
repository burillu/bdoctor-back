<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\profile;

class Specialtie extends Model
{
    protected $fillable = [
        'name',
    ];

    public function profiles(){
        return $this->hasMany(Profile::class);
    }

    use HasFactory;
}
