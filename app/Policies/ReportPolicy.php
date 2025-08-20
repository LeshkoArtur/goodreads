<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Models\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Політика для моделі Report.
 */
class ReportPolicy
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
     * Визначає, чи може користувач переглядати будь-які звіти.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Визначає, чи може користувач переглядати звіт.
     *
     * @param User $user
     * @param Report $report
     * @return bool
     */
    public function view(User $user, Report $report): bool
    {
        return $report->user_id === $user->id || $user->isAdmin();
    }

    /**
     * Визначає, чи може користувач створювати звіти.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Визначає, чи може користувач оновлювати звіт.
     *
     * @param User $user
     * @param Report $report
     * @return bool
     */
    public function update(User $user, Report $report): bool
    {
        return $report->user_id === $user->id;
    }

    /**
     * Визначає, чи може користувач видаляти звіт.
     *
     * @param User $user
     * @param Report $report
     * @return bool
     */
    public function delete(User $user, Report $report): bool
    {
        return $report->user_id === $user->id;
    }
}
