<?php

namespace App\Repository\Situator;

use GuzzleHttp\Client as guzz;
use GuzzleHttp\Psr7\Request;
use App\Exceptions\ClientException;
use App\Models\CredentialModel;

trait CredentialSituatorTrait
{

    protected function getFormatedUrlToCredential()
    {
        return $this->getFormatedUrlToAccount() . self::ENDPOINT_CREDENTIALS;
    }

    public function createCredential(CredentialModel $credential)
    {   
        $nextNumber = $this->getNextNumber();
        $credential->setNumber($nextNumber);
        $body = $credential->getBodyToCredentialCreate();
        $bodyJson = json_encode($body);
        $request = new Request(
            'POST',
            $this->getFormatedUrlToCredential(),
            self::HEADER,
            $bodyJson
        );
        $res = $this->client->sendAsync($request)->wait();
        if($res->getStatusCode() != self::HTTP_OK){
            throw new ClientException('Unable to Create Credential');
        }
        $responseBodyAsString = $res->getBody()->getContents();
        return json_decode($responseBodyAsString,true);
    }

    private function getNextNumber()
    {
        $request = new Request(
            'GET',
            $this->getFormatedUrlToCredential().self::ENDPOINT_NEXT_NUMBER,
            self::HEADER
        );
        $res = $this->client->sendAsync($request)->wait();
        if($res->getStatusCode() != self::HTTP_OK){
            throw new ClientException('Unable to get next-number');
        }
        $responseBodyAsString = $res->getBody()->getContents();
        $data = json_decode($responseBodyAsString,true);
        return $data['nextNumber'];
    }
}
