<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;
    protected $fillable = ['name','price','duration'];
    public function profiles()
    {
        return $this->belongsToMany(Profile::class)->withPivot('expire_date', 'current_price')->withTimestamps();
    }
}

