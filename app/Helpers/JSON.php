<?php


namespace App\Helpers;

/**
 * Class JSON - Used for JSON responses.
 * @package App\Helpers
 */
class JSON
{

    protected $type, $status, $message, $code, $data, $additional;

    /**
     * @param mixed $type
     */
    public function setResponseType($type): JSON
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param mixed $additional
     */
    public function setAdditional($additional)
    {
        $this->additional = $additional;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdditional()
    {
        return $this->additional;
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
        // Uses the same structure as model resources, for consistency when they aren't used.
        $response = [
            'data' => $this->getData(),
            'meta' => [
                'status' => $this->getStatus(),
                'message' => $this->getMessage(),
            ]
        ];

        if (!empty($this->additional))
        {
            foreach($this->additional as $additionalKeyName => $key)
            {
                $response[$additionalKeyName] = $key;
            }
        }
        return response($response, $this->getCode(), $headers);
    }

}
