<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grades extends Model
{
    //
    protected $fillable = [
        'user',
        'subject',
        'grade',
    ];

    public function groups()
    {
        return $this->belongsTo(Subjects::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
