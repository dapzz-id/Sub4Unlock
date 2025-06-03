<?php

namespace App\Policies;

use App\Models\UnlockLink;
use App\Models\User;

class UnlockLinkPolicy
{
    public function update(User $user, UnlockLink $link)
    {
        return $user->id === $link->user_id;
    }

    public function delete(User $user, UnlockLink $link)
    {
        return $user->id === $link->user_id;
    }
}