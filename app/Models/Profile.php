<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Specialty;
use App\Models\Vote;
use App\Models\Sponsorship;


class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','curriculum','image','tel','visibility','address','services','slug'
    ];

    public function user(){
        return $this->belongTo(User::class);
    }

    public function specialties(){
        return $this->belongsToMany(Specialty::class);
    }

    public function votes(){
        return $this->belongsToMany(Vote::class);
    }
    public function sponsorships(){
        return $this->belongsToMany(Sponsorship::class);
    }
}
