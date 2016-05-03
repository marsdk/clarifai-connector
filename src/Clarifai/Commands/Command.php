<?php 

namespace Marsdk\Clarifai\Commands;

use Marsdk\Clarifai\Auth\Auth;
use Curl\Curl;

abstract class Command {

    /**
     * @var Curl $curl;
     */
    protected $curl;

    /**
     * @var string $token
     */
    protected $token;

    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var Auth $auth
     */
    protected $auth;

    /**
     * Command constructor.
     *
     * @param Auth $auth
     */
    public function __construct($auth = null)
    {
        if ($auth) {
            $this->setToken($auth->getResponse()->getAccessToken());
            $this->setCurl($auth->getCurl());
        }
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
     * @return Command
     */
    public function setCurl($curl)
    {
        $this->curl = $curl;

        return $this;
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param Auth $auth
     *
     * @return Command
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;

        return $this;
    }


    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return Command
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Command
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
    
      
    
}