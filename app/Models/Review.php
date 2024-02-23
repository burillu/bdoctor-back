<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Profile;

class Review extends Model
{
    use HasFactory;
    public $timestamps = false;
    //protected $guarded=[];
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
