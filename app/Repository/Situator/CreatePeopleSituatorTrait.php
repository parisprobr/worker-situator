<?php
namespace App\Repository\Situator;
use GuzzleHttp\Client as guzz;
use GuzzleHttp\Psr7\Request;

trait CreatePeopleSituatorTrait{

    public function createPeople(int $idEs)
    {
        $body = $this->getBodyToPeopleCreate();
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

    protected function getBodyToPeopleCreate(
        string $name,
        boolean $active,
        int $gender,
        string $cpf,
        string $document
    )
    {
        $body = array(
            'name' => $name,
            'active' => $active,
            'gender' => $gender,
            'cpf' => '01073373045',
            'document' => '44545453',
            'email' => 'fulana2@comercial.com',
            'personType' => 1,
            'phone' => '98766543',
            'phoneType' => 1,
            'department' => self::DEPARTMENT,
            'observation' => 'Contratada PJ',
            'birthday' => '1987-01-09T00:00:00',
            'company' => 'XYZ CIA LTDA',
            'duressPassword' => 'socorro',
            'responsible' => true,
            'imported' => false,
            'accessPermission' => true
        );
        return $body;
    }

}