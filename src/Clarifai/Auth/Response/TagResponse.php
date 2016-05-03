<?php

namespace Marsdk\Clarifai\Auth\Response;

class TagResponse {

    /**
     * @var float $metaTimestamp
     */
    protected $metaTimestamp;

    /**
     * @var string $metaModel
     */
    protected $metaModel;

    /**
     * @var mixed $result
     */
    protected $result;

    /**
     * @var array $tags
     */
    protected $tags;

    /**
     * TagResponse constructor.
     */
    public function __construct($response)
    {
        $metaTagData = $response->meta->tag;

        $this->setMetaTimestamp($metaTagData->timestamp);
        $this->setMetaModel($metaTagData->model);

        // Get the tags and probability values.
        $this->transformResultData($response->results);

    }

    /**
     * @return float
     */
    public function getMetaTimestamp()
    {
        return $this->metaTimestamp;
    }

    /**
     * @param float $metaTimestamp
     *
     * @return TagResponse
     */
    public function setMetaTimestamp($metaTimestamp)
    {
        $this->metaTimestamp = $metaTimestamp;

        return $this;
    }

    /**
     * @return string
     */
    public function getMetaModel()
    {
        return $this->metaModel;
    }

    /**
     * @param string $metaModel
     *
     * @return TagResponse
     */
    public function setMetaModel($metaModel)
    {
        $this->metaModel = $metaModel;

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
     * @return TagResponse
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     *
     * @return TagResponse
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Transform the Tag data from the API into a useable array.
     *
     * @param object $resultData
     *
     * @throws \Exception
     */
    protected function transformResultData($resultData) {

        // Throw error result data is not present.
        if (!is_array($resultData) && !array_key_exists(0, $resultData)) {
            throw new \Exception('Result data was not found');
        }

        // Throw error if we are missing tags.
        if (!isset($resultData[0]->result->tag)) {
            throw new \Exception('Result data not properly formatted');
        }

        // Initialize.
        $resultObject = $resultData[0]->result->tag;
        $tagData = [];

        if (!empty($resultObject->classes)) {

            // For all tags add the probability.
            foreach ($resultObject->classes as $index => $tagName) {

                // Set probability to -1 is we do not find any.
                $probability = -1;

                // Use it, if set.
                if (isset($resultObject->probs[$index])) {
                    $probability = $resultObject->probs[$index];
                }

                $tagData[$tagName] = $probability;

            }
        }

        $this->setTags($tagData);
    }
    
}