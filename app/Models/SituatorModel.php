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
        $this->repository   = New SituatorRepository();
        $this->repositoryEs = New EntradaSeguraRepository();
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
    
    public function createPeople(int $idSituator,int $idEs)
    {     
        $this->simpleLogin($idSituator);
        return $this->repository->createPeople($idEs);
    }
    
    public function getPeopleByCpf(int $idSituator,string $cpf)
    {   
        $this->simpleLogin($idSituator);
        return $this->repository->getPeopleByCpf($cpf);
    }


    public function deletePeopleByCpf(int $idSituator,string $cpf)
    {     
        $this->simpleLogin($idSituator);
        return $this->repository->deletePeopleByCpf($cpf);
    }

}
