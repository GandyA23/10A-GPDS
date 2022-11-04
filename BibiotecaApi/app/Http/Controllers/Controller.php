<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $response = [];
    private $httpStatus = 200;
    protected const GENERIC_MESSAGES = [
        'error' => 'Operation failed!',
        'success' => 'Operation success!',
        'try_later' => 'Please try later',
    ];

    // Setters
    protected function setStatus($status)
    {
        $this->response['status'] = $status;
    }

    protected function setMessage($message)
    {
        $this->response['message'] = $message;
    }

    protected function setData($data)
    {
        $this->response['data'] = $data;
    }

    protected function setError($data)
    {
        $this->response['error'] = $data;
    }

    protected function setHttpStatus($httpStatus)
    {
        $this->httpStatus = $httpStatus;
    }

    protected function setJsonResponse($status, $message, $data, $httpStatus = 0)
    {
        $this->response = [
            'status' => $status,
            'message' => $message
        ];
        $this->response[$status ? 'data' : 'error'] = $data;
        $this->httpStatus = (!$httpStatus ? ($status ? 200 : 500) : $httpStatus);
    }

    // Getters
    protected function getJsonResponse()
    {
        return $this->response;
    }

    protected function getHttpStatus()
    {
        return $this->httpStatus;
    }

    protected function getResponse()
    {
        return [
            $this->getJsonResponse(),
            $this->getHttpStatus()
        ];
    }

    // Other functions
    /**
     * Check if all data is valid to do any operation
     * @param Array $data Dato to validate
     * @param Array $rules Validations to fields
     * @param Array $messages Custom messages to fields inside the array
     * @return Array Error messages
     */
    protected function isValid($data, $rules, $messages = [])
    {
        $validator = Validator::make($data, $rules, $messages);
        $errors = [];

        if ($validator->fails())
        {
            $errors = $validator->errors();
        }

        return $errors;
    }
}
