<?php

namespace Marsdk\Clarifai\Auth;

use Marsdk\Clarifai\Auth\Client\Client;
use Marsdk\Clarifai\Auth\Response\AuthResponse;
use Marsdk\Clarifai\Auth\Response\Response;
use Marsdk\Clarifai\Auth\Response\ResponseHandler;
use Curl\Curl;

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
     * @var Response $response;
     */
    protected $response;

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

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     *
     * @return Auth
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }



    public function authenticate()
    {
        $this->getCurl()->setBasicAuthentication($this->getClient()->getClientId(),
            $this->getClient()->getClientSecret());

        $this->curl->post('https://api.clarifai.com/v1/token/', [
            'grant_type' => $this->getClient()->getGrantType()
        ]);

        // Create a response object from the Curl result.
        $responseHandler = new ResponseHandler($this->curl->response);

        // Throw an error if we get an error from the API.
        if ($responseHandler->getResponse() instanceof Response) {
            throw new \Exception($responseHandler->getResponse()->getStatusMsg());
        }

        $this->setResponse($responseHandler->getResponse());
    }
    
}