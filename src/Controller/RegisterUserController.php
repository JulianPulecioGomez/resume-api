<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\User\UseCase\RegisterNewUserUseCase;
use App\Request\UserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterUserController extends AbstractController
{
    public function __invoke(UserRequest $request, RegisterNewUserUseCase $useCase): User
    {
        return $useCase->handle($request);
    }
}
