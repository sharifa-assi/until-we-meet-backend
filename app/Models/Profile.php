<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = ['weight','height','username','status','user_id','pregnancy_date','period_date'];
public function user(){
        return $this->belongsTo(User::class);
    }

}
