<?php

namespace Marsdk\Clarifai\Commands;

use Marsdk\Clarifai\Auth\Auth;
use Marsdk\Clarifai\Auth\Response\ResponseHandler;
use Marsdk\Clarifai\Helpers\JsonHelper;

class Tag extends Command {

    /**
     * Model for the how the API should tag sent image / video.
     *
     * When images or videos are run through the tag endpoint, they are tagged
     * using a model. A model is a trained classifier that can recognize what is
     * inside an image or video according to what it 'knows'. Different models
     * are trained to 'know' different things. Running an image or video through
     * different models can produce drastically different results.
     *
     * - general-v1.3
     * - nsfw-v1.0
     * - weddings-v1.0
     *
     * @var string $model
     */
    protected $model;

    /**
     * The string that contains an image or video.
     *
     * @var string $encodedData
     */
    protected $encodedData;

    /**
     * @var array $encodedFileData
     */
    protected $encodedFileData;

    /**
     * Tag constructor.
     *
     * @param Auth $auth
     * @param string $url
     * @param string $model
     */
    public function __construct($auth = null, $url = null, $model = null)
    {
        parent::__construct($auth);

        if (!$url) {
            $this->setUrl('https://api.clarifai.com/v1/tag/');
        }
    }
    
    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     *
     * @return Tag
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
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
     * @return Tag
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

    /**
     * @return string
     */
    public function getEncodedData()
    {
        return $this->encodedData;
    }

    /**
     * @param string $encodedData
     *
     * @return Tag
     */
    public function setEncodedData($encodedData)
    {
        $this->encodedData = $encodedData;

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

        $responseHandler = new ResponseHandler($this->curl->response);
        return $responseHandler;
    }


}