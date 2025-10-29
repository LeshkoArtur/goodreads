<?php

namespace App\Policies;

use App\Models\AuthorQuestion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі AuthorQuestion.
 */
class AuthorQuestionPolicy
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
     * Визначає, чи може користувач переглядати будь-які питання до авторів.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати питання до автора.
     */
    public function view(User $user, AuthorQuestion $authorQuestion): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати питання до авторів.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати питання до автора.
     */
    public function update(User $user, AuthorQuestion $authorQuestion): bool
    {
        return $authorQuestion->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти питання до автора.
     */
    public function delete(User $user, AuthorQuestion $authorQuestion): bool
    {
        return $authorQuestion->user_id === $user->id;
    }
}
