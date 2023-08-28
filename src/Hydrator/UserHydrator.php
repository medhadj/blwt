<?php

namespace App\Hydrator;


use App\Entity\User;

class UserHydrator
{
    /**
     * @param User $user
     * @param array $arguments
     * @return User
     */
    public static function hydrate(User $user, array $arguments)
    {
        if (isset($arguments['email'])) {
            $user->setEmail($arguments['email']);

        }
        if (isset($arguments['password'])) {
            $user->setPassword(sha1($arguments['password']));
        }

        return $user;
    }

}
