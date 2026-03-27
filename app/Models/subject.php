<?php

namespace App\Models;

use App\Models\Grade;

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

    public function scopeSearch($query, $name)
    {
        return $query->when($name, function ($q) use ($name) {
            $q->where('name', 'like', "%{$name}%");
        });
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
