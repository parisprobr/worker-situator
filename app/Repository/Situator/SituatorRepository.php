<?php

namespace App\Repository\Situator;

use GuzzleHttp\Client as guzz;
use GuzzleHttp\Psr7\Request;
use App\Exceptions\ClientException;


class SituatorRepository
{

    use LoginSituatorTrait;
    use CreatePeopleSituatorTrait;

    const HEADER                = ['Content-Type' => 'application/json', 'Accept' => 'application/json'];
    const COOKIE_AUTH_NAME      = 'Seventh.Auth';
    const ENDPOINT_LOGIN        = '/login';
    const ENDPOINT_CURRENT_USER = '/current-user';
    const ENDPOINT_PEOPLE       = '/people';
    const ENDPOINT_ACCOUNTS     = '/accounts';
    const ENDPOINT_IMAGE     = '/image';
    const FILTER_CPF            = 'pagination.filters.cpf=';
    const DEPARTMENT            = 'ES';
    const HTTP_NOT_FOUND        = 404;
    const HTTP_OK               = 200;

    public function __construct()
    {
        $this->client = new guzz(['cookies' => true]);
    }

    private function getFormattedUrlToPeople()
    {
        return $this->apiUrl . self::ENDPOINT_ACCOUNTS . '/' . $this->accountId . '/' . self::ENDPOINT_PEOPLE;
    }

    

    public function getPeopleByCpf(string $cpf)
    {
        $request = new Request(
            'GET',
            $this->getFormattedUrlToPeople() . '?' . self::FILTER_CPF . $cpf,
            self::HEADER,
        );
        $res = $this->client->sendAsync($request)->wait();
        $peoples = json_decode($res->getBody()->getContents(), true);
        if (
            !isset($peoples['pagination']['count'])
            || !$peoples['pagination']['count']
            || !$peoples['people'][0]['id']
        ) {
            throw new ClientException('People not Found with cpf: ' . $cpf, self::HTTP_NOT_FOUND);
        }
        return $peoples['people'][0];
    }


    private function peopleBelongsEs(array $people)
    {
        if ($people['department'] == self::DEPARTMENT) {
            return true;
        }
    }

    public function deletePeopleByCpf(string $cpf)
    {
        $people = $this->getPeopleByCpf($cpf);
        if (!$this->peopleBelongsEs($people)) {
            throw new ClientException('People Id:' . $people['id'] . ' not Belongs ES', 403);
        }

        $request = new Request(
            'DELETE',
            $this->getFormattedUrlToPeople() . '/' . $people['id'],
            self::HEADER,
        );
        $res = $this->client->sendAsync($request)->wait();
        if($res->getStatusCode() != self::HTTP_OK){
            throw new ClientException('Unable to remove user Id'.$people['id']);
        }
        return 'User Removed';
    }

    public function setPeopleImage(string $cpf, string $base64)
    {   
        $people = $this->getPeopleByCpf($cpf);
        if (!$this->peopleBelongsEs($people)) {
            throw new ClientException('People Id:' . $people['id'] . ' not Belongs ES', 403);
        }

        $body     = ['base64' => $base64];
        $bodyJson = json_encode($body);

        $request = new Request(
            'PUT',
            $this->getFormattedUrlToPeople() . '/' . $people['id'].self::ENDPOINT_IMAGE,
            self::HEADER,
            $bodyJson
        );
        $res = $this->client->sendAsync($request)->wait();
        if($res->getStatusCode() != self::HTTP_OK){
            throw new ClientException('Unable to change image for user Id'.$people['id']);
        }
        return 'successfully changed image';
    }
}
