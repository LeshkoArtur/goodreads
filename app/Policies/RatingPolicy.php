<?php

namespace App\Policies;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Rating.
 */
class RatingPolicy
{
    use HandlesAuthorization;

    /**
     * Виконується перед усіма перевірками авторизації.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Визначає, чи може користувач переглядати будь-які оцінки.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати оцінку.
     */
    public function view(User $user, Rating $rating): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати оцінки.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати оцінку.
     */
    public function update(User $user, Rating $rating): bool
    {
        return $rating->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти оцінку.
     */
    public function delete(User $user, Rating $rating): bool
    {
        return $rating->user_id === $user->id;
    }
}
