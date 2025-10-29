<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Report.
 */
class ReportPolicy
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
     * Визначає, чи може користувач переглядати будь-які звіти.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Визначає, чи може користувач переглядати звіт.
     */
    public function view(User $user, Report $report): bool
    {
        return $report->user_id === $user->id || $user->isAdmin();
    }

    /**
     * Визначає, чи може користувач створювати звіти.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати звіт.
     */
    public function update(User $user, Report $report): bool
    {
        return $report->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти звіт.
     */
    public function delete(User $user, Report $report): bool
    {
        return $report->user_id === $user->id;
    }
}
