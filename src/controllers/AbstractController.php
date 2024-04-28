<?php

namespace App\controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractController
{

    public function json(?array $data, int $status = 200, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $status, $headers);
    }
}