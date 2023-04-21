<?php

namespace App\Models;

use App\Models\CredentialModel;
use App\Repository\EntradaSeguraRepository;
use App\Repository\Situator\SituatorRepository;

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

    public function getPeopleAccessByCpf(int $idSituator, string $cpf)
    {
        $this->simpleLogin($idSituator);
        $people = $this->repository->getPeopleByCpf($cpf);
        return $this->repository->getAccessByPeopleId($people['id']);
    }

    public function deletePeopleAccessByCpf(int $idSituator, string $cpf)
    {
        $this->simpleLogin($idSituator);
        $people = $this->repository->getPeopleByCpf($cpf);
        return $this->repository->deleteAccessByPeopleId($people['id']);
    }

    public function setPeopleAccessByCpf(int $idSituator, string $cpf, PeopleAccessModel $accessModel)
    {
        $this->simpleLogin($idSituator);
        $people = $this->repository->getPeopleByCpf($cpf);
        return $this->repository->setAccessByPeopleId($people['id'],$accessModel);
    }

    public function setPeopleCredentialByCpf(int $idSituator, string $cpf, int $credetialId)
    {
        $this->simpleLogin($idSituator);
        $people = $this->repository->getPeopleByCpf($cpf);
        return $this->repository->setPeopleCredential($people['id'],$credetialId);
    }

    public function createCredential(int $idSituator, CredentialModel $credential)
    {
        $this->simpleLogin($idSituator);
        return $this->repository->createCredential($credential);
    }

}
