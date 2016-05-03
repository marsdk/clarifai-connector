<?php

namespace Marsdk\Clarifai\Auth\Response;

use Marsdk\Clarifai\Helpers\JsonHelper;

class ResponseHandler {

    /**
     * @var Response|AuthResponse $response
     */
    protected $response;

    /**
     * @var array $expectedFields
     */
    protected $expectedFields = ['status_code', 'status_msg'];

    /**
     * @var array $authResponseFields
     */
    protected $authResponseFields = ['access_token', 'expires_in', 'scope', 'token_type'];

    /**
     * Response constructor.
     */
    public function __construct($response)
    {
        $this->manageResponse($response);
    }

    /**
     * @return AuthResponse|Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param AuthResponse|Response $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * Handle what response class we will return based on the $response data.
     *
     * @param $response
     *
     * @return AuthResponse|Response
     * @throws \Exception
     */
    protected function manageResponse($response) {

        if (is_string($response)) {

            // This should be a JSON formatted string. In such case transform it
            // to an object. If not throw an error.

            if (!$this->checkIfJson($response)) {
                throw new \Exception('The given response string is not a JSON string.');
            }

            // Transform into object.
            $response = @json_decode($response);

        }

        // At this point we should have a object in $response.
        if (!is_object($response)) {
            throw new \Exception('The given response is not an object.');
        }

        // Check if the have the expected properties or auth properties back
        // from API.
        $expectedProperties = $this->hasPropertiesExists($response, 'expected');
        $authProperties = $this->hasPropertiesExists($response, 'auth');

        if ($expectedProperties == false && $authProperties == false) {
            throw new \Exception('No required properties were found on the result object from the API.');
        }

        // Handle what response class we will return based on the result data.
        if ($expectedProperties == true) {

            // This is a normal response from the system.
            // Check status codes.
            if ($response->status_code == 'OK') {
                $isTag = $this->hasPropertiesTags($response);
                $isColor = $this->hasPropertiesColors($response);

                if ($isTag) {
                    $returnResponse = new TagResponse($response);
                }
                elseif ($isColor) {
                    $returnResponse = new ColorResponse($response);
                }
                else {
                    $returnResponse = new Response($response);
                }
            }
            else {
                // Return general response.
                $returnResponse = new Response($response);
            }
        } else if ($authProperties == true) {
            $returnResponse = new AuthResponse($response);
        } else {
            throw new \Exception('No response could be returned.');
        }

        $this->setResponse($returnResponse);
    }

    /**
     * Check if a given string is a JSON formatted string.
     *
     * @param string $string
     *
     * @return bool
     *   Return true if string is JSON. Otherwise false.
     */
    protected function checkIfJson($string) {
        @json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Check if we have all of the properties on the response.
     *
     * @param string $propertyType
     */
    protected function hasPropertiesExists($response, $propertyType = 'expected') {

        switch ($propertyType) {
            case 'auth':
                $validationFields = $this->authResponseFields;
                break;

            case 'expected':
            default;
                $validationFields = $this->expectedFields;
                break;
        }

        $validationFieldCount = count($validationFields);
        $propertyExistsCount = 0;

        foreach ($validationFields as $fieldName) {
            if (property_exists($response, $fieldName)) {
                $propertyExistsCount++;
            }
        }

        if ($validationFieldCount == $propertyExistsCount) {
            return true;
        }

        return false;
    }

    protected function hasPropertiesTags($response) {

        // Check if the property meta is found on $response and is an object.
        if (!property_exists($response, 'meta') && is_object($response)) {
            return false;
        }

        // Get the meta data.
        $meta = $response->meta;
        if (!property_exists($meta, 'tag')) {
            return false;
        }

        // If we have a meta object and a tag property on it, this should be
        // a proper Tag response.
        return true;
    }

    protected function hasPropertiesColors($response) {


        // Check if the property meta is found on $response and is an object.
        if (!property_exists($response, 'results') && is_object($response)) {
            return false;
        }

        // Get the meta data.
        $results = $response->results;

        if (empty($results) || !is_array($results)) {
            return false;
        }

        // Get the first item from the top of the array.
        $resultObject = reset($results);

        if (!property_exists($resultObject, 'colors') || !is_array($resultObject->colors)) {
            return false;
        }

        // If we have a meta object and a tag property on it, this should be
        // a proper Tag response.
        return true;
    }
    
}