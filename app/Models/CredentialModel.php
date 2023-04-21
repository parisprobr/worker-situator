<?php

namespace App\Models;

class CredentialModel
{   
    private int $number;

    public function __construct(
        private int $cardType,
        private int $value
    ) {
    }

    public function setNumber(int $number)
    {
        $this->number = $number;
    }

    public function getBodyToCredentialCreate()
    {
        $body = array(
            'number'        => $this->number,
            'cardType'      => $this->cardType,
            'value'         => $this->value
        );
        return $body;
    }
}
