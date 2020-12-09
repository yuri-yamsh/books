<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractApiController extends AbstractController
{
    public function successResponse(string $message, array $data, int $status = 200, array $headers = [])
    {
        return new JsonResponse(
            [
                'message' => $message,
                'data' => $data
            ],
            $status,
            $headers
        );
    }

    public function errorResponse(string $message, array $errors, int $status = 400, array $headers = [])
    {
        return new JsonResponse(
            [
                'message' => $message,
                'errors' => $errors
            ],
            $status,
            $headers
        );
    }
}