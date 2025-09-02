<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AuthorQuestion;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі AuthorQuestion.
 */
class AuthorQuestionPolicy
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
     * Визначає, чи може користувач переглядати будь-які питання до авторів.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати питання до автора.
     *
     * @param User $user
     * @param AuthorQuestion $authorQuestion
     * @return bool
     */
    public function view(User $user, AuthorQuestion $authorQuestion): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач створювати питання до авторів.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати питання до автора.
     *
     * @param User $user
     * @param AuthorQuestion $authorQuestion
     * @return bool
     */
    public function update(User $user, AuthorQuestion $authorQuestion): bool
    {
        return $authorQuestion->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти питання до автора.
     *
     * @param User $user
     * @param AuthorQuestion $authorQuestion
     * @return bool
     */
    public function delete(User $user, AuthorQuestion $authorQuestion): bool
    {
        return $authorQuestion->user_id === $user->id;
    }
}
