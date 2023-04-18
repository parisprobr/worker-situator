<?php
namespace App\Repository;


use Illuminate\Support\Facades\DB;

class SituatorRepository
{
    public function createUser($idEs)
    {   
       return array('idEs' => $idEs);
    }

}
