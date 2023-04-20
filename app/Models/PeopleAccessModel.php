<?php

namespace App\Models;

class PeopleAccessModel
{

    public function __construct(
        private string $pin,
        private string $apartment,
        private string $block,
        private string $administrator,
        private string $startDate,
        private string $validity,
        private string $password,
        private string $parentId,
        private string $imported,
        private string $active,
        private string $type
    ) {
    }

    public function getBodyToAccessCreate()
    {
        $body = array(
            'pin'           => $this->pin,
            'apartment'     => $this->apartment,
            'block'         => $this->block,
            'administrator' => $this->administrator,
            'startDate'     => $this->startDate,
            'validity'      => $this->validity,
            'password'      => $this->password,
            'parentId'      => $this->parentId,
            'imported'      => $this->imported,
            'active'        => $this->active,
            'type'          => $this->type
        );
        return $body;
    }
}
