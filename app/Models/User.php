<?php

namespace App\Models;

use App\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, Cachable;

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
     * Define roles relationship
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Return the default relationship collection
     *
     * @return Collection
     */
    protected function getDefaultRelation(): Collection
    {
        return $this->roles;
    }

    /**
     * Check if user has specific permissions
     *
     * @param  string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        // Iterate through each role to check if the user has the permission
        foreach ($this->getCache() as $role) {
            // Check if the role has the permission in its cached permissions
            if ($role->getCache()->where('name', $permission)->isNotEmpty()) {
                return true; // Return true if the permission is found
            }
        }
        return false; // Return false if the permission is not found in any role
    }

    /**
     * Check if user can access the panel
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }
}
