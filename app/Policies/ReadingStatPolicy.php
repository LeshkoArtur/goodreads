<?php

namespace App\Policies;

use App\Models\ReadingStat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі ReadingStat.
 */
class ReadingStatPolicy
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
     * Визначає, чи може користувач переглядати будь-які статистики читання.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати статистику читання.
     */
    public function view(User $user, ReadingStat $readingStat): bool
    {
        return $readingStat->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати статистики читання.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати статистику читання.
     */
    public function update(User $user, ReadingStat $readingStat): bool
    {
        return $readingStat->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти статистику читання.
     */
    public function delete(User $user, ReadingStat $readingStat): bool
    {
        return $readingStat->user_id === $user->id;
    }
}
