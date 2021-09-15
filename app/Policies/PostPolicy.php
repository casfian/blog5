<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Post $post)
    {
        //Kalau User Id yg login sama dengan user Id dalam Post sama
        //maka kita boleh delete
        return $user->id === $post->user_id;
    }
}
