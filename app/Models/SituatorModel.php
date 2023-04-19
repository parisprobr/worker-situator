<?php

namespace App\Models;

use App\Repository\Situator\SituatorRepository;
use App\Repository\EntradaSeguraRepository;

class SituatorModel
{
    private SituatorRepository $repository;
    private EntradaSeguraRepository $repositoryEs;

    public function __construct()
    {
        $this->repository   = new SituatorRepository();
        $this->repositoryEs = new EntradaSeguraRepository();
    }

    private function simpleLogin(int $idSituator)
    {
        $data = $this->repositoryEs->getDataLogin($idSituator);
        $this->repository->login(
            $data['apiUrl'],
            $data['userName'],
            $data['password'],
            $data['accountId'],
            $data['rememberMe']
        );
    }

    public function createPeople(
        int $idSituator,
        int $idEs,
        PeopleModel $people
    ) {
       
        $this->simpleLogin($idSituator);
        return $this->repository->createPeople($people);
    }

    public function getPeopleByCpf(int $idSituator, string $cpf)
    {
        $this->simpleLogin($idSituator);
        return $this->repository->getPeopleByCpf($cpf);
    }


    public function deletePeopleByCpf(int $idSituator, string $cpf)
    {
        $this->simpleLogin($idSituator);
        return $this->repository->deletePeopleByCpf($cpf);
    }

    public function setPeopleImage(int $idSituator, string $cpf,string $base64)
    {
        $this->simpleLogin($idSituator);
        return $this->repository->setPeopleImage($cpf, $base64);
    }
}
