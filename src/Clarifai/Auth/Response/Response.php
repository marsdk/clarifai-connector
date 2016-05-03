<?php

namespace Marsdk\Clarifai\Auth\Response;

class Response {

    /**
     * Status code returned from the API
     *
     * @var string $statusCode
     */
    protected $statusCode;

    /**
     * The status message from the API.
     *
     * @var string $statusMsg
     */
    protected $statusMsg;

    /**
     * The result returned from the API.
     *
     * @var mixed $result
     */
    protected $result;

    /**
     * Response constructor.
     */
    public function __construct($curlResponse = null)
    {
        if (isset($curlResponse->status_code)) {
            $this->setStatusCode($curlResponse->status_code);
        }

        if (isset($curlResponse->status_msg)) {
            $this->setStatusMsg($curlResponse->status_msg);
        }

        if (isset($curlResponse->result)) {
            $this->setResult($curlResponse->result);
        }
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param string $statusCode
     *
     * @return Response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusMsg()
    {
        return $this->statusMsg;
    }

    /**
     * @param string $statusMsg
     *
     * @return Response
     */
    public function setStatusMsg($statusMsg)
    {
        $this->statusMsg = $statusMsg;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     *
     * @return Response
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }




}