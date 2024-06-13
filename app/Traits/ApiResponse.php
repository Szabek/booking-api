<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Returns a successful JSON response.
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function success(mixed $data, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Returns an error JSON response.
     *
     * @param string $message
     * @param mixed|null $data
     * @param int $code
     * @return JsonResponse
     */
    protected function error(string $message, mixed $data = null, int $code = 400): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}
