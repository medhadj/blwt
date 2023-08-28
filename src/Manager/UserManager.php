<?php

namespace App\Manager;


use App\Entity\User;
use App\Hydrator\UserHydrator;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserManager
{
    public function __construct(EntityManagerInterface $manager, UserRepository $user)
    {
        $this->user = $user;
        $this->manager = $manager;
    }

    public function verificationUserBlauwtrust(Request $request)
    {
        // Retrieve data from the request body
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];

        //Check if the email already exists
        $email_exist = $this->user->findOneByEmail($email);

        if ($email_exist) {
            return array('status' => false, 'message' => 'This email already exists, please change it');
        } else {
            $user = new User();
            //Check and set data
            $user = UserHydrator::hydrate($user, $data);

            $this->manager->persist($user);
            $this->manager->flush();

            return array('status' => true, 'message' => 'User created successfully');
        }
    }
}
