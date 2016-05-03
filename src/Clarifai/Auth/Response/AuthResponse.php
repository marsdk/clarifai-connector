<?php

namespace Marsdk\Clarifai\Auth\Response;

class AuthResponse
{

    /**
     * Access token used for the API
     *
     * Eg. U5j3rECLLZ86pWRjK35g489QJ4zrQI.
     *
     * @var string $accessToken
     */
    protected $accessToken;

    /**
     * Expire time defined in seconds.
     *
     * Eg. 172800.
     *
     * @var integer $expiresIn
     */
    protected $expiresIn;

    /**
     * Scope for the response.
     *
     * Eg. api_access.
     *
     * @var string $scope
     */
    protected $scope;

    /**
     * Description of the token type.
     *
     * Eg. Bearer.
     *
     * @var string $tokenType
     */
    protected $tokenType;

    /**
     * AuthResponse constructor.
     */
    public function __construct($response = null)
    {
        if (isset( $response->access_token )) {
            $this->setAccessToken($response->access_token);
        }

        if (isset( $response->expires_in )) {
            $this->setExpiresIn($response->expires_in);
        }

        if (isset( $response->scope )) {
            $this->setScope($response->scope);
        }

        if (isset( $response->token_type )) {
            $this->setTokenType($response->token_type);
        }
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     *
     * @return AuthResponse
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     *
     * @return AuthResponse
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;

        return $this;
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     *
     * @return AuthResponse
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * @param string $tokenType
     *
     * @return AuthResponse
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;

        return $this;
    }

}