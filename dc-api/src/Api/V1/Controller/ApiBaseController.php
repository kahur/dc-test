<?php

namespace DC\Api\V1\Controller;

use DC\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiBaseController extends BaseController
{
    const STATUS_OK = 'ok';
    const STATUS_ERROR = 'error';

    /**
     * @param mixed $data
     * @param string $status
     * @return JsonResponse
     */
    public function response($data, $status = self::STATUS_OK): JsonResponse
    {
        $response = [
            'status' => $status
        ];

        if ($status === self::STATUS_ERROR) {
            $response['error'] = $data;
        } else {
            $response['content'] = $data;
        }

        return $this->json($response);
    }
}