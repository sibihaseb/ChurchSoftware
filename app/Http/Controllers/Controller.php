<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Success response
     *
     * @param  JsonResource  $data
     * @param  bool  $resourceCreated
     * @return JsonResponse
     */
    protected function successResponse(JsonResource $data, bool $resourceCreated = false): JsonResponse
    {
        return response()
            ->json(
                $data,
                $resourceCreated ?
                    Response::HTTP_CREATED :
                    Response::HTTP_OK
            );
    }

    /**
     * Success Message response
     *
     * @param  string  $successMessage
     * @param  int  $responseCode
     * @return JsonResponse
     */
    protected function successMessageResponse(string $successMessage, int $responseCode): JsonResponse
    {
        return response()
            ->json(
                ['message' => $successMessage],
                $responseCode
            );
    }

    /**
     * Error response
     *
     * @param  string  $errorMessage
     * @param  int  $responseCode
     * @return JsonResponse
     */
    protected function errorResponse(string $errorMessage, int $responseCode): JsonResponse
    {
        return response()
            ->json(
                ['message' => $errorMessage],
                $responseCode
            );
    }

    /**
     * Delete response
     *
     * @return JsonResponse
     */
    protected function deleteResponse(): JsonResponse
    {
        return response()
            ->json(
                null,
                Response::HTTP_NO_CONTENT
            );
    }
    public function currentApp()
    {
        $currentApp = DB::table('temporary_app_codes')->where('user_id', auth()->user()?->id)->first();
        return $currentApp;
    }
}
