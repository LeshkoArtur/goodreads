<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rating;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Rating.
 */
class RatingPolicy
{
    use HandlesAuthorization;

    /**
     * Виконується перед усіма перевірками авторизації.
     *
     * @param User $user
     * @param string $ability
     * @return bool|null
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
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати оцінку.
     *
     * @param User $user
     * @param Rating $rating
     * @return bool
     */
    public function view(User $user, Rating $rating): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати оцінки.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати оцінку.
     *
     * @param User $user
     * @param Rating $rating
     * @return bool
     */
    public function update(User $user, Rating $rating): bool
    {
        return $rating->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти оцінку.
     *
     * @param User $user
     * @param Rating $rating
     * @return bool
     */
    public function delete(User $user, Rating $rating): bool
    {
        return $rating->user_id === $user->id;
    }
}
