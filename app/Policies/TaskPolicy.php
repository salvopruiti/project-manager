<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tasks.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {

    }

    /**
     * Determine whether the user can view the task.
     *
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function view(User $user, Task $task): bool
    {
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function update(User $user, Task $task): bool
    {
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function delete(User $user, Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the task.
     *
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function restore(User $user, Task $task): bool
    {
    }

    /**
     * Determine whether the user can permanently delete the task.
     *
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function forceDelete(User $user, Task $task): bool
    {
    }
}
