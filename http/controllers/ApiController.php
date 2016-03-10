<?php namespace Autumn\Api\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

abstract class ApiController extends Controller
{
    /**
     * Http status code.
     *
     * @var int
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * Get the http status code.
     *
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the http status code.
     *
     * @param int $statusCode
     * @return $this
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Send the response as json
     *
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data = [], array $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Send the error response as json
     *
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError($message = null)
    {
        $statusCode = $this->getStatusCode();
        $message = $message ?: Response::$statusTexts[$statusCode];

        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $statusCode
            ]
        ]);
    }

    /**
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondCreated($data = [], array $headers = [])
    {
        return $this->setStatusCode(Response::HTTP_CREATED)->respond($data, $headers);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNoContent()
    {
        return $this->setStatusCode(Response::HTTP_NO_CONTENT)->respond();
    }

    /**
     * Send a not found response
     *
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNotFound($message = null)
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * Send an unprocessable entity response
     *
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondUnprocessable($message = null)
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }
}
