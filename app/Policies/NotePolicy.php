<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Note.
 */
class NotePolicy
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
     * Визначає, чи може користувач переглядати будь-які нотатки.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач переглядати нотатку.
     */
    public function view(User $user, Note $note): bool
    {
        return ! $note->is_private || $note->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач створювати нотатки.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати нотатку.
     */
    public function update(User $user, Note $note): bool
    {
        return $note->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти нотатку.
     */
    public function delete(User $user, Note $note): bool
    {
        return $note->user_id === $user->id;
    }
}
