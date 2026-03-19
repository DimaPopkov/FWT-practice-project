<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    protected $table = 'subject';
    use HasFactory;
    //
    protected $fillable = [
        'name'
    ];

    public function grades()
    {
        return $this->belongsTo(Grade::class);
    }
}
