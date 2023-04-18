<?php
namespace App\Models;


use App\Repository\SituatorRepository;

class SituatorModel
{
    private $repository;
    public function __construct()
    {
        $this->repository = New SituatorRepository();
    }

    public function createUser($idEs)
    {
        return $this->repository->createUser($idEs);
    }

}
