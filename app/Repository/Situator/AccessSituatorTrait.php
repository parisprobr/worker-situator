<?php

namespace App\Repository\Situator;

use GuzzleHttp\Client as guzz;
use GuzzleHttp\Psr7\Request;
use App\Exceptions\ClientException;
use App\Models\PeopleAccessModel;

trait AccessSituatorTrait
{

    protected function getFormatedUrlToPeopleAccess(int $peopleId)
    {
        return $this->getFormattedUrlToPeople() . '/' . $peopleId . self::ENDPOINT_ACCESS;
    }

    public function getAccessByPeopleId(int $peopleId)
    {   
        $request = new Request(
            'GET',
            $this->getFormatedUrlToPeopleAccess($peopleId),
            self::HEADER,
        );
        try {
            $res = $this->client->sendAsync($request)->wait();
        } catch (\Throwable $th) {
            if ($th->getResponse()->getStatusCode() == self::HTTP_NOT_FOUND) {
                throw new ClientException('Access not Found with People Id: ' . $peopleId, self::HTTP_NOT_FOUND);
            }
        }
        $access = json_decode($res->getBody()->getContents(), true);
        
        return $access['access'];
    }

    public function deleteAccessByPeopleId(int $peopleId)
    {   
        $request = new Request(
            'DELETE',
            $this->getFormatedUrlToPeopleAccess($peopleId),
            self::HEADER,
        );
        try {
            $res = $this->client->sendAsync($request)->wait();
        } catch (\Throwable $th) {
            if ($th->getResponse()->getStatusCode() == self::HTTP_NOT_FOUND) {
                throw new ClientException('Access not Found with People Id: ' . $peopleId, self::HTTP_NOT_FOUND);
            }
        }

        if($res->getStatusCode() == self::HTTP_OK){
            return 'Access deleted successfully for the Id People Id:'.$peopleId;
        }
    }

    public function setAccessByPeopleId(int $peopleId, PeopleAccessModel $access)
    {   
        $bodyJson = json_encode($access->getBodyToAccessCreate());
        $request = new Request(
            'POST',
            $this->getFormatedUrlToPeopleAccess($peopleId),
            self::HEADER,
            $bodyJson
        );
        try {   
            $res = $this->client->sendAsync($request)->wait();
        } catch (\Throwable $th) {
            if($th->getResponse()->getStatusCode() == self::HTTP_INTERNAL_ERROR){
                throw new ClientException('Access Found with People Id: ' . $peopleId, self::HTTP_INTERNAL_ERROR);
            }
            throw $th;
        }
        if($res->getStatusCode() == self::HTTP_OK){
            return 'Access created successfully for the People Id: '.$peopleId;
        }
        throw new ClientException('Access not created');
    }
    
}
