<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    public function grades()
    {
        return $this->belongsTo(Grade::class);
    }
}
