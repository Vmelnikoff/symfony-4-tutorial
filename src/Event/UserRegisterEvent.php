<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserRegisterEvent extends Event
{
    public const NAME = 'user.register';

    /**
     * @var User
     */
    private $registredUser;

    public function __construct(User $registredUser)
    {
        $this->registredUser = $registredUser;
    }

    public function getRegistredUser(): User
    {
        return $this->registredUser;
    }


}