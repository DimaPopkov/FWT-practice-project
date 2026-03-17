<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    public function user()
    {
        return $this->hasMany(User::class); 
    }
}
