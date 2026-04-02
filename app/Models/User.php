<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 1;
    public const ROLE_TEACHER = 2;
    public const ROLE_STUDENT = 3;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'group_id',
        'email',
        'role',
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday' => 'date',
            'address' => 'array',
        ];
    }

    protected function formattedBirthday(): Attribute
    {
        return Attribute::get(
            fn () =>
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

    public function scopeFilter($query, array $filters)
    {
        return $query
            // Фильтр по ФИО
            ->when($filters['name'] ?? null, function ($q, $name) {
                $q->where('name', 'like', "%{$name}%");
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
