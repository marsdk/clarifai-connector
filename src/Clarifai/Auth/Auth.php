<?php

namespace marsdk\Clarifai\Auth;

class Auth {
    /**
     * @var Client;
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var Curl
     */
    protected $curl;

    /**
     * Auth constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->setClient($client);
        $this->setCurl(new Curl());
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     *
     * @return Auth
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     *
     * @return Auth
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Curl
     */
    public function getCurl()
    {
        return $this->curl;
    }

    /**
     * @param Curl $curl
     *
     * @return Auth
     */
    public function setCurl($curl)
    {
        $this->curl = $curl;

        return $this;
    }

    public function authenticate()
    {
        $this->getCurl()->setBasicAuthentication($this->getClient()->getClientId(),
            $this->getClient()->getClientSecret());

        dd($this->curl->response);
    }

}