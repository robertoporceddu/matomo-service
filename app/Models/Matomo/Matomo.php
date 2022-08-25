<?php

namespace App\Models\Matomo;

use App\Services\MatomoService;

class Matomo {

    protected $matomo;

    function __construct()
    {
        $this->matomo = new MatomoService();
    }

    public function returnObjectFromResponse($object, $response)
    {
        foreach($object->fillable as $i => $attribute) {
            $object->$attribute = $response->$attribute;
        }

        return $object;
    }
}