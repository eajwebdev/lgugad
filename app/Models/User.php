<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'gender',
        'username',
        'password',
        'role',
        'access',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Position of each module's flag in the `access` CSV (matches the checkboxes in user/user-list).
     */
    public const MODULES = [
        'dafac' => 0,
        'pwd' => 1,
        'soloparent' => 2,
        'womens' => 3,
        'senior' => 4,
        'vawc' => 5,
        'admin' => 6,
        'daycare' => 7,
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function canAccessModule(string $module): bool
    {
        if (! array_key_exists($module, self::MODULES)) {
            return false;
        }

        $flags = explode(',', (string) $this->access);

        return ($flags[self::MODULES[$module]] ?? '0') === '1';
    }

    /**
     * Builds the `access` CSV from the checked module indexes; admins always get the admin flag.
     */
    public static function buildAccess(array $checkedIndexes, string $role): string
    {
        $flags = array_fill(0, count(self::MODULES), '0');

        foreach (array_keys($checkedIndexes) as $index) {
            if (isset($flags[$index])) {
                $flags[$index] = '1';
            }
        }

        $flags[self::MODULES['admin']] = $role === 'Administrator' ? '1' : '0';

        return implode(',', $flags);
    }
}
