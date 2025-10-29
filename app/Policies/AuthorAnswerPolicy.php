<?php

namespace App\Policies;

use App\Models\AuthorAnswer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі AuthorAnswer.
 */
class AuthorAnswerPolicy
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
     * Визначає, чи може користувач переглядати будь-які відповіді авторів.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати відповідь автора.
     */
    public function view(User $user, AuthorAnswer $authorAnswer): bool
    {
        return $user->exists; // Відповіді доступні для всіх автентифікованих
    }

    /**
     * Визначає, чи може користувач створювати відповіді авторів.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати відповідь автора.
     */
    public function update(User $user, AuthorAnswer $authorAnswer): bool
    {
        return $authorAnswer->author_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти відповідь автора.
     */
    public function delete(User $user, AuthorAnswer $authorAnswer): bool
    {
        return $authorAnswer->author_id === $user->id;
    }
}
