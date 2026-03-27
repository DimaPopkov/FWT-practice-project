<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'user',
        'subject',
        'grade',
    ];

    protected function statusColor(): Attribute
    {
        return Attribute::get(function () {
            return match (true) {
                $this->score >= 5 => 'table-success', // Зеленый (Bootstrap 5)
                $this->score >= 4 => 'table-warning', // Желтый
                default           => 'table-danger',  // Красный
            };
        });
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
