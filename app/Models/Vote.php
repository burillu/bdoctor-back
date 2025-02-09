<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Profile;

class Vote extends Model
{
    use HasFactory;
    protected $table = 'votes';
    protected $fillable = ['value'];

    public function profiles(){
        return $this->belongsToMany(Profile::class)->withTimestamps();
    }
}
