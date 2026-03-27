<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\Group;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fio',
        'group_id',
        'birthday',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'birthday' => 'date',
            'address' => 'array',
        ];
    }

    protected function formattedBirthday(): Attribute
    {
        return Attribute::get(fn () => 
            $this->birthday ? $this->birthday->format('d-m-Y') : 'Не указана'
        );
    }

    protected function address(): Attribute
    {
        return Attribute::set(function ($value) {
            return collect($value)->map(function ($item) {
                return is_string($item) ? Str::ucfirst(Str::lower($item)) : $item;
            })->toArray();
        });
    }

    protected function fullAddress(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->address) return 'Адрес не указан';

            return "г. {$this->address['city']}, ул. {$this->address['street']}, д. {$this->address['house']}";
        });
    }

    public function isExcellentStudent(): bool
    {
        return $this->grades->isNotEmpty() 
            && $this->grades->every('grade', 5);
    }

    public function isGoodStudent(): bool
    {
        return $this->grades->isNotEmpty() 
            && $this->grades->every('grade', '>=', 4) 
            && $this->grades->avg('grade') < 5;
    }

    public function getGradeClassAttribute(): string
    {
        if ($this->isExcellentStudent()) {
            return 'table-success';
        }

        if ($this->isGoodStudent()) {
            return 'table-warning';
        }

        return 'table-danger';
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            // Фильтр по ФИО
            ->when($filters['fio'] ?? null, function ($q, $fio) {
                $q->where('fio', 'like', "%{$fio}%");
            })
            // Фильтр по дате рождения
            ->when($filters['birthday'] ?? null, function ($q, $date) {
                $q->whereDate('birthday', $date);
            });
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
