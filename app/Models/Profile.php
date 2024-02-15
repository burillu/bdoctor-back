<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Specialty;
use App\Models\Vote;
use App\Models\Sponsorship;
use App\Models\Review;
use App\Models\Lead;


class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','curriculum','image','tel','visibility','address','services','slug'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function specialties(){
        return $this->belongsToMany(Specialty::class);
    }

    public function votes(){
        return $this->belongsToMany(Vote::class)->withTimestamps();
    }
    public function sponsorships(){
        return $this->belongsToMany(Sponsorship::class)->withPivot('expire_date', 'current_price')->withTimestamps();
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function leads(){
        return $this->hasMany(Lead::class);
    }
}
