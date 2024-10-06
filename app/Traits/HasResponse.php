<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HasResponse
{
    protected array $response_array;

    public function __construct()
    {
        $this->response_array = [
            'data' => null,
            'message' => '',
            'success' => true,
            'status' => 200
        ];
    }

    public static function setResponse(
        $data = null,
        bool $success = true,
        string $message = '',
        int $status = 200
    ): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => $success,
            'status' => $status,
        ], $status);
    }

    protected function respond(): JsonResponse
    {
        return response()->json($this->response_array, $this->response_array['status']);
    }

    protected function unsuccessful($data = [], int $status = 500, string $message = ''): static
    {
        $this->response_array['data'] = $data;
        $this->response_array['success'] = false;
        $this->response_array['status'] = $status;
        $this->response_array['message'] = $message;
        return $this;
    }

    protected function successful($data = null, string $message = null, int $status = 200): static
    {
        $this->response_array['data'] = $data;
        $this->response_array['message'] = $message;
        $this->response_array['status'] = $status;
        return $this;
    }

    public function ok($data = null, string $message = 'Success!'): JsonResponse
    {
        return $this->successful($data, $message)->respond();
    }

    public function created($data = null, string $message = 'Created!'): JsonResponse
    {
        return $this->successful(
            data: $data,
            message: $message,
            status: 201
        )->respond();
    }

    public function notFound(string $message = 'Not Found!'): JsonResponse
    {
        return $this->unsuccessful(
            status: 404,
            message: $message
        )->respond();
    }

    public function serverError(string $message = 'Server Error!'): JsonResponse
    {
        return $this->unsuccessful(
            message: $message
        )->respond();
    }

    public function badRequest(string $message = 'Bad Request!'): JsonResponse
    {
        return $this->unsuccessful(
            status: 400,
            message: $message
        )->respond();
    }

    public function unauthorized(string $message = 'Unauthorized!'): JsonResponse
    {
        return $this->unsuccessful(
            status: 401,
            message: $message
        )->respond();
    }

    public function forbidden(string $message = 'Forbidden!'): JsonResponse
    {
        return $this->unsuccessful(
            status: 403,
            message: $message
        )->respond();
    }

    public function validationError(string $message = 'Validation Error!'): JsonResponse
    {
        return $this->unsuccessful(
            status: 422,
            message: $message
        )->respond();
    }
}
