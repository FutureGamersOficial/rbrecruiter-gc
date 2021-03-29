<?php


namespace App\Helpers;

/**
 * Class JSON - Used for JSON responses.
 * @package App\Helpers
 */
class JSON
{

    protected $type, $status, $message, $code, $data;

    /**
     * @param mixed $type
     */
    public function setResponseType($type): JSON
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return JSON
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return JSON
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return JSON
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return JSON
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function build($headers = [])
    {
        $response = [
            'status' => $this->getStatus(),
            'message' => $this->getMessage(),
            'type' => $this->getType(),
            'response' => $this->getData()
        ];

        return response($response, $this->getCode(), $headers);
    }

}
