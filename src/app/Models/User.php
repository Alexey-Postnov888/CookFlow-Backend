<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $primaryKey = 'sub';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sub',
        'name',
        'preferred_username',
        'given_name',
        'family_name',
        'email',
        'email_verified',
        'realm_access',
    ];

    protected function casts(): array
    {
        return [
            'email_verified'   => 'boolean',
            'realm_access'     => 'array',
        ];
    }

    public function getRolesAttribute(): array
    {
        return $this->realm_access['roles'] ?? [];
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRolesAttribute());
    }
}
