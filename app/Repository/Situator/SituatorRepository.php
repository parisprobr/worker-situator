<?php
namespace App\Repository\Situator;
use GuzzleHttp\Client as guzz;
use GuzzleHttp\Psr7\Request;

use Illuminate\Support\Facades\DB;

class SituatorRepository
{   

    use LoginSituatorTrait;
    const ENDPOINT_LOGIN        = '/login';
    const ENDPOINT_CURRENT_USER = '/current-user';

    const HEADER           = ['Content-Type' => 'application/json', 'Accept' => 'application/json'];
    const COOKIE_AUTH_NAME = 'Seventh.Auth';

    
    public function __construct()
    {   
        $this->client = new guzz(['cookies' => true]); 
    }
    

    public function createUser($idEs)
    {   
       return array('@TODO CreateUser');
    }

}
