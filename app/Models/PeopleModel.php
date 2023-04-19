<?php

namespace App\Models;

class PeopleModel
{   

    const DEFAULT_DEPARTMENT = 'ES';
    const DEFAULT_IMPORTED   = false;

    public function __construct(
        private int $idEs,
        private string $name,
        private bool $active,
        private int $gender,
        private string $cpf,
        private string $document,
        private string $email,
        private int $personType,
        private string $phone,
        private int $phoneType,
        private string $observation,
        private string $birthday,
        private string $company,
        private string $duressPassword,
        private bool $responsible,
        private bool $accessPermission
    ) {
    }

    public function getBodyToPeopleCreate()
    {
        $body = array(
            'name' => $this->name,
            'active' => $this->active,
            'gender' => $this->gender,
            'cpf' => $this->cpf,
            'document' => $this->document,
            'email' => $this->email,
            'personType' => $this->personType,
            'phone' => $this->phone,
            'phoneType' => $this->phoneType,
            'department' => self::DEFAULT_DEPARTMENT,
            'observation' => $this->observation,
            'birthday' => $this->birthday,
            'company' => $this->company,
            'duressPassword' => $this->duressPassword,
            'responsible' => $this->responsible,
            'imported' => self::DEFAULT_IMPORTED,
            'accessPermission' => $this->accessPermission
        );
        return $body;
    }
}
