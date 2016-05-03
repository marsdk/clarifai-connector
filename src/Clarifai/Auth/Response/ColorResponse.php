<?php

namespace Marsdk\Clarifai\Auth\Response;

class ColorResponse {

    /**
     * @var array $colors
     */
    protected $colors;

    /**
     * @return array
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * @param array $colors
     *
     * @return ColorResponse
     */
    public function setColors($colors)
    {
        $this->colors = $colors;

        return $this;
    }


    public function __construct($response)
    {
        // Get the colors and density.
        $this->transformResultData($response->results);

    }

    protected function transformResultData($resultData) {

        $colorData = $resultData[0]->colors;

        $colorResults = [];
        if (!empty($colorData) && is_array($colorData)) {

            foreach ($colorData as $color) {

                // Collect in a more human way.
                $singleColor = [];
                $singleColor['w3c_hex'] = $color->w3c->hex;
                $singleColor['w3c_name'] = $color->w3c->name;
                $singleColor['hex'] = $color->hex;
                $singleColor['density'] = $color->density;

                // Add to result.
                $colorResults[] = $singleColor;
            }
        }

        $this->setColors($colorResults);
    }

}
