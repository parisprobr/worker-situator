<?php

namespace App\Repository\Situator;

use GuzzleHttp\Client as guzz;
use GuzzleHttp\Psr7\Request;
use App\Exceptions\ClientException;
use App\Models\CredentialModel;
use App\Models\PeopleModel;


trait PeopleSituatorTrait
{

    protected function getFormattedUrlToPeople()
    {
        return $this->getFormatedUrlToAccount() . self::ENDPOINT_PEOPLE;
    }

    public function createPeople(PeopleModel $people)
    {   
        $body = $people->getBodyToPeopleCreate();
        $bodyJson = json_encode($body);
        $request = new Request(
            'POST',
            $this->getFormattedUrlToPeople(),
            self::HEADER,
            $bodyJson
        );
        $res = $this->client->sendAsync($request)->wait();
        if($res->getStatusCode() != self::HTTP_OK){
            throw new ClientException('Unable to CreateUser user');
        }
        $responseBodyAsString = $res->getBody()->getContents();
        return json_decode($responseBodyAsString,true);
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


    protected function peopleBelongsEs(array $people)
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
            throw new ClientException('Unable to change image for People Id:'.$people['id']);
        }
        return 'successfully changed image';
    }

    public function setPeopleCredential(int $peopleId, int $credentialId)
    {   
        $body     = [
            'id'        => $credentialId,
            'duress'    => true
        ];
        $bodyJson = json_encode($body);
        $request = new Request(
            'POST',
            $this->getFormattedUrlToPeople() . '/' . $peopleId.self::ENDPOINT_CREDENTIALS,
            self::HEADER,
            $bodyJson
        );
        $res = $this->client->sendAsync($request)->wait();
        if($res->getStatusCode() != self::HTTP_OK){
            throw new ClientException('Unable to set Credential to People Id: '.$people['id']);
        }
        return 'successfully set Credential';
    }

}
