<?php

namespace App\Repository\Situator;

use GuzzleHttp\Client as guzz;
use GuzzleHttp\Psr7\Request;
use App\Exceptions\ClientException;


class SituatorRepository
{

    use LoginSituatorTrait;
    use PeopleSituatorTrait;
    use AccessSituatorTrait;
    use CredentialSituatorTrait;

    const HEADER                = ['Content-Type' => 'application/json', 'Accept' => 'application/json'];
    const COOKIE_AUTH_NAME      = 'Seventh.Auth';
    const ENDPOINT_LOGIN        = '/login';
    const ENDPOINT_CURRENT_USER = '/current-user';
    const ENDPOINT_PEOPLE       = '/people';
    const ENDPOINT_ACCOUNTS     = '/accounts';
    const ENDPOINT_ACCESS       = '/access';
    const ENDPOINT_IMAGE        = '/image';
    const ENDPOINT_CREDENTIALS  = '/credentials';
    const ENDPOINT_NEXT_NUMBER  = '/next-number';
    const FILTER_CPF            = 'pagination.filters.cpf=';
    const DEPARTMENT            = 'ES';
    const HTTP_NOT_FOUND        = 404;
    const HTTP_OK               = 200;
    const HTTP_INTERNAL_ERROR   = 500;

    public function __construct()
    {
        $this->client = new guzz(['cookies' => true]);
    }

    protected function getFormatedUrlToAccount()
    {
        return $this->apiUrl . self::ENDPOINT_ACCOUNTS . '/' . $this->accountId;
    }

    
}
