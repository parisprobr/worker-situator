<?php
namespace App\Repository;
use Illuminate\Support\Facades\DB;

class EntradaSeguraRepository
{
    public function getDataLogin(int $idSituator)
    {   
        $dataLogin = [];
        //https://apidev.entradasegura.com.br/docs
        switch ($idSituator) {
            case 1:
                $dataLogin = [
                    'apiUrl'     => 'http://possebon.freeddns.org:8080/api',
                    'userName'   => 'admin',
                    'password'   => 'EntradaSegura',
                    'rememberMe' => true,
                    'accountId'  =>  1000
                ];
                break;
        }

        return $dataLogin;
    }


}
