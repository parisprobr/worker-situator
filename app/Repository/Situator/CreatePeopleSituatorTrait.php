<?php

namespace App\Repository\Situator;

use GuzzleHttp\Client as guzz;
use GuzzleHttp\Psr7\Request;
use App\Models\PeopleModel;
use App\Exceptions\ClientException;


trait CreatePeopleSituatorTrait
{

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

}
