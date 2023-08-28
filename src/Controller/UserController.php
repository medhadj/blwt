<?php

namespace App\Controller;

use App\Manager\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @param UserManager $userManager
     */
    public function __construct(
        private UserManager $userManager,
    )
    {
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/user-create', name: 'user_create', methods: 'POST')]
    public function userCreate(Request $request): Response
    {
        $userStatus = $this->userManager->verificationUserBlauwtrust($request);
        return new JsonResponse
        (
            [
                'status' => $userStatus['status'],
                'message' => $userStatus['message'],
            ]

        );


    }

}
