<?php

namespace Marsdk\Clarifai\Commands;

use Marsdk\Clarifai\Auth\Auth;
use Marsdk\Clarifai\Auth\Response\ResponseHandler;
use Marsdk\Clarifai\Helpers\JsonHelper;

class Color extends Command {

    /**
     * @var array $encodedFileData
     */
    protected $encodedFileData;

    /**
     * Color constructor.
     *
     * @param Auth $auth
     * @param string $url
     */
    public function __construct($auth = null, $url = null, $model = null)
    {
        parent::__construct($auth);

        if (!$url) {
            $this->setUrl('https://api.clarifai.com/v1/color/');
        }
    }

    /**
     * @return array
     */
    public function getEncodedFileData()
    {
        return $this->encodedFileData;
    }

    /**
     * @param array $encodedFileData
     *
     * @return Color
     */
    public function setEncodedFileData($encodedFileData)
    {
        $this->encodedFileData = $encodedFileData;

        return $this;
    }

    public function addImageUsingUrl($url) {
        $fileData = $this->getEncodedFileData();
        $fileData[] = base64_encode(file_get_contents($url));
        $this->setEncodedFileData($fileData);
        return $this;

    }

    public function execute() {
        $fileData = $this->getEncodedFileData();
        if (count($fileData) < 1) {
            throw new \Exception('No image was added.');
        }

        $this->getCurl()->setHeader('Authorization', 'Bearer ' .  $this->getToken());
        $this->getCurl()->post($this->getUrl(), [
            'encoded_data' => '@' . $fileData[0]
        ]);

        dd($this->curl->response);

        $responseHandler = new ResponseHandler($this->curl->response);
        return $responseHandler;
    }
    
}