<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','curriculum','image','tel','visibility','address','services'
    ];

    public function user(){
        return $this->belongTo(User::class);
    }
    public function sponsorships(){
        return $this->belongsToMany(Sponsorship::class);
    }
}
