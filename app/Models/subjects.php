<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subjects extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    public function grades()
    {
        return $this->belongsTo(Grades::class);
    }
}
