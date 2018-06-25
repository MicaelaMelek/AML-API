<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Spatie\Fractal\FractalFacade;

class ApiController extends Controller
{


    protected $statusCode = 200;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }


    /**
     * @param $model
     * @param $transformer
     * @return mixed
     */
    public function respondItem($model, $transformer)
    {
        return FractalFacade::item($model)
            ->transformWith($transformer)
            ->respond($this->getStatusCode());
    }

    /**
     * @param $collection
     * @param $transformer
     * @return mixed
     */
    public function respondCollection($collection, $transformer)
    {
        return FractalFacade::collection($collection)
            ->transformWith($transformer)
            ->respond($this->getStatusCode());
    }


    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(JsonResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param string $messages
     * @return mixed
     */
    public function respondInternalError($messages = 'Internal server error')
    {
        if (is_array($messages)) {
            return $this->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithErrors($messages);
        }
        return $this->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($messages);
    }

    /**
     * @param string $messages
     * @return mixed
     */
    public function respondBadRequest($messages = 'Bad request')
    {
        if (is_array($messages)) {
            return $this->setStatusCode(JsonResponse::HTTP_BAD_REQUEST)->respondWithErrors($messages);
        }

        return $this->setStatusCode(JsonResponse::HTTP_BAD_REQUEST)->respondWithError($messages);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondConflict($message = 'Conflict')
    {
        return $this->setStatusCode(JsonResponse::HTTP_CONFLICT)->respondWithError($message);
    }

    /**
     * @param $validations
     * @return mixed
     */
    public function respondUnprocessable($validations)
    {
        return $this->setStatusCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)->getValidationErrors($validations);
    }
    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(JsonResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
    }
    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(JsonResponse::HTTP_FORBIDDEN)->respondWithError($message);
    }
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function respondCreated($data = [])
    {
        return $this->setStatusCode(JsonResponse::HTTP_CREATED)->respond($data);
    }

    /**
     * @param $validations
     * @return mixed
     */
    public function respondValidationFail($validations)
    {
        return $this->setStatusCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)->getValidationErrors($validations);
    }

    /**
     * @param $args
     * @return mixed
     */
    public function respondSuccess($args = [])
    {
        return $this->respond(
            [
                'status' => $this->getStatusCode(),
                'detail' => isset($args['message']) ? $args['message'] : null,
                'data' => isset($args['data']) ? $args['data'] : [],
            ]
        );
    }

    /**
     * @return mixed
     */
    public function respondOnlyMetaData()
    {
        return $this->respond(
            [
                'meta' => [
                    'code' => $this->getStatusCode()
                ]
            ]
        );
    }

    /**
     * @param $message
     * @param null $data
     * @return mixed
     */
    public function respondWithError($message, $data = null)
    {
        return $this->respond(
            [
                'errors' => [
                    [
                        'status' => $this->getStatusCode(),
                        'detail' => $message,
                        'data' => $data
                    ]
                ]
            ]
        );
    }

    /**
     * @param $validations
     * @return mixed
     */
    public function respondWithErrorValidation($validations)
    {
        return $this->respond(
            [
                'errors' => [
                    'status' => $this->getStatusCode(),
                    'details' => $validations
                ]
            ]
        );
    }

    /**
     * @param $validations
     * @return mixed
     */
    public function getValidationErrors($validations)
    {
        $details = [];

        foreach ($validations->toArray() as $field => $message) {
            $details[] = [$field => $message];
        }

        $errors = [
            'title' => "Invalid Attributes",
            'details' => $details
        ];

        return $this->respond(['errors' => [$errors]]);
    }


    /**
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return JsonResponse::create($data, $this->getStatusCode(), $headers);
    }

    private function respondWithErrors($messages)
    {
        $details = [];

        foreach ($messages as $message) {
            $details[] = [
                'status' => $message['status'],
                'detail' => $message['detail']
            ];
        }

        return $this->respond(['errors' => $details]);
    }

}