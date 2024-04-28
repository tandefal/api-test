<?php

namespace App\controllers;

use App\services\UserService;
use App\validators\UserValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{

    public function create(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $validator = new UserValidator();
        if($err = $validator->create($data)) {
            return $this->json($err, 400);
        }
        $service = new UserService();
        return $this->json(['success' => $service->create($data['name'])]);
    }

    public function remove(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $validator = new UserValidator();
        if($err = $validator->remove($data)) {
            return $this->json($err, 400);
        }
        $service = new UserService();
        $id = $data['id'];
        return $this->json(['success' => $service->remove(compact('id'))]);
    }

    public function all(): JsonResponse
    {
        $service = new UserService();
        return $this->json(['response' => $service->all()]);
    }
}