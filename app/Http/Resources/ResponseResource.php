<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    // define property
    public $code;
    public $status;
    public $message;
    public $resource;

    /**
     * __construct
     *
     * @param  mixed $code
     * @param  mixed $status
     * @param  mixed $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($code, $status, $message, $resource)
    {
        parent::__construct($resource);
        $this->code = $code;
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * toArray
     *
     * @param  mixed $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->resource
        ];
    }

    public static function success($code=200, $status=true, $message, $data = [])
    {
        return response()->json([
            'code'   => $code,
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    public static function error($code=400, $status=false, $message, $errors = [])
    {
        return response()->json([
            'code'   => $code,
            'status'  => $status,
            'message' => $message,
            'errors'  => $errors
        ], $code);
    }
}
