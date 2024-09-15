<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\MessageBag;

trait HttpResponses {

    public function response (string $message, int $status, array|Model|JsonResource $data = []) {
        return response()->json([
            'message' => $message,
            'status'    => $status,
            'data'   => $data,
        ], $status);
    }

    public function error (string $message, int $status, array|MessageBag $errors = [], array|Model $data = []) {
        return response()->json([
            'message' => $message,
            'status'    => $status,
            'errors'   => $errors,
            'data'   => $data,
        ], $status);
    }

}
