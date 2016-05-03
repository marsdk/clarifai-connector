<?php

namespace Marsdk\Clarifai\Auth\Client;

class Client {

    protected $clientId;

    protected $clientSecret;

    protected $grantType;

    /**
     * Client constructor.
     *
     * @param $clientId
     * @param $clientSecret
     */
    public function __construct($clientId, $clientSecret, $grantType = null)
    {
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;

        // Set a default granttype if not set.
        if (!$grantType) {
            $this->setGrantType('client_credentials');
        }
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     *
     * @return Auth
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param mixed $clientSecret
     *
     * @return Auth
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    /**
     * @param mixed $grantType
     *
     * @return Auth
     */
    public function setGrantType($grantType)
    {
        $this->grantType = $grantType;

        return $this;
    }
}