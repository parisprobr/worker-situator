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

    public function createUser($idSituator,$idEs)
    {     
        $data = $this->repositoryEs->getDataLogin($idSituator);
        $login = $this->repository->login(
            $data['apiUrl'],
            $data['userName'],
            $data['password'],
            $data['accountId'], 
            $data['rememberMe']
        );
        return $this->repository->createUser($idSituator, $idEs);
    }

    public function getUserByName($idSituator, $name)
    {   
        dd('aaaaa');
        dd($idSituator, $name);
    }


}
