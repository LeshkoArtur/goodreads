<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\Role;
use App\Models\Builders\UserQueryBuilder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\{
    BelongsToMany,
    HasMany
};
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;


/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'username',
        'email',
        'password',
        'email_verified_at',
        'profile_picture',
        'bio',
        'is_public',
        'birthday',
        'location',
        'last_login',
        'social_media_links',
        'role',
        'gender',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_public' => 'boolean',
        'birthday' => 'date',
        'last_login' => 'datetime',
        'social_media_links' => AsCollection::class,
        'role' => Role::class,
        'gender' => Gender::class,
    ];

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_user');
    }

    public function shelves(): HasMany
    {
        return $this->hasMany(Shelf::class);
    }

    public function books(): HasMany
    {
        return $this->hasMany(UserBook::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function viewHistories(): HasMany
    {
        return $this->hasMany(ViewHistory::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_members')->withPivot('role', 'status');
    }

    public function groupInvitations(): HasMany
    {
        return $this->hasMany(GroupInvitation::class, 'invitee_id');
    }

    public function eventRsvps(): HasMany
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function isAdmin(): bool
    {
        return $this->role == Role::ADMIN;
    }
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function getFilamentName(): string
    {
        return $this->username ?? $this->email ?? 'Без імені';
    }
}
