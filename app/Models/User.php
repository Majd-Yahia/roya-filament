<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;



class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, \Znck\Eloquent\Traits\BelongsToThrough;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * roles
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }


    // Left join approach
    /**
     * Define a relationship to access permissions through roles.
     *
     * @return BelongsToMany
     */
    // public function permissions(): BelongsToMany
    // {
    //     return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id')
    //         ->leftJoin('role_user', 'permission_role.role_id', '=', 'role_user.role_id')
    //         ->where('role_user.user_id', $this->id);
    // }

    /**
     * Define a relationship to access permissions through roles.
     *
     * @return HasManyThrough
     */
    public function permissions(): HasManyThrough
    {
        return $this->hasManyThrough(
            Permission::class,
            RolePermission::class,
            'role_id',
            'id',
            'id',
            'permission_id'
        );
    }
    /**
     * Check if user has specific permissions
     *
     * @param  mixed $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        $subset = $this->permissions->pluck('name')->toArray();
        return in_array($permission, $subset);
    }

    /**
     * Check if user can access the panel
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@admin.com') && $this->hasVerifiedEmail();
    }
}
