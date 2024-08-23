<?php


namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponses
{
    public function successResponse(mixed $data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'data' => $data,
        ], $statusCode);
    }

    public function errorResponse(mixed $data, string $message = '', int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        if (!$message) {
            $message = Response::$statusTexts[$statusCode];
        }

        $data = [
            'message' => $message,
            'errors' => $data,
        ];

        return response()->json([
            'status' => $statusCode,
            'data' => $data,
        ], $statusCode);
    }
}
