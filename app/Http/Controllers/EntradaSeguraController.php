<?php

namespace App\Http\Controllers;

use App\Models\CredentialModel;
use App\Models\PeopleAccessModel;
use Illuminate\Http\Request;
use App\Models\SituatorModel;
use App\Models\PeopleModel;

use function PHPUnit\Framework\throwException;

class EntradaSeguraController extends Controller
{

    public function __construct()
    {
        
    }

    private function splitRequest(Request $request)
    {   
        $listRequests = [];
        $separator = '__';
        if(!$request->hasHeader('idSituator')){
            throw new \Exception('idSituator not defined in Header Request', 500);
        }
        
        $allParameters = [];

        foreach($request->all() as $key => $value){
            if(!strstr($key, $separator)){
                $allParameters[$key] = $value;
                continue;
            }
            $parts = explode($separator, $key);
            $nameRequest = $parts[0];
            $nameColumn  = $parts[1];
            if(!isset($listRequests[$nameRequest])){
                $listRequests[$nameRequest] = new Request();
                $listRequests[$nameRequest]->headers->set('idSituator', $request->header('idSituator'));
            }
            $listRequests[$nameRequest]->merge([$nameColumn => $value]);
        }

        foreach($listRequests as $nameRequest => $oneRequest){
            $listRequests[$nameRequest]->merge($allParameters);
        }

        return $listRequests;
    }

    public function createPeopleWithAccess(Request $request)
    {   
        $errorList  = [];
        $actionList = [];
        $situatorController = New SituatorController();
        $requests = $this->splitRequest($request);
        
        if(!array_key_exists('people', $requests)){
            throw new \Exception('Request people not found in requests', 500);
        }
        $peopleRequest = $requests['people'];
        $accessRequest = $requests['access'];

        try {
            $actionList['resPeopleDelete'] = $situatorController->deletePeopleByCpf($peopleRequest);
        } catch (\Throwable $th) {
            $errorList['deletePeopleByCpf'] = $th->getMessage();
        }

        try {
            $actionList['resPeopleCreate'] = $situatorController->createPeople($peopleRequest);
        } catch (\Throwable $th) {
            $errorList['createPeople'] = $th->getMessage();
        }

        try {
            $actionList['resSetImage'] = $situatorController->setPeopleImage($peopleRequest);
        } catch (\Throwable $th) {
            $errorList['setPeopleImage'] = $th->getMessage();
        }

        try {
            $actionList['resCreateCredential'] = $situatorController->createCredential($accessRequest);
        } catch (\Throwable $th) {
            $errorList['createCredential'] = $th->getMessage();
        }        
        try {   
            $resCreateCredetial = json_decode($actionList['resCreateCredential']->getContent(), true);
            $accessRequest->merge([
                'credentialId'  => $resCreateCredetial['response']['credential']['id'],
            ]);
            $actionList['setPeopleCredentialByCpf'] = $situatorController->setPeopleCredentialByCpf($accessRequest);
        } catch (\Throwable $th) {
            $errorList['setPeopleCredentialByCpf'] = $th->getMessage();
        }

        try {
            $actionList['setPeopleAccessByCpf'] = $situatorController->setPeopleAccessByCpf($accessRequest);
        } catch (\Throwable $th) {
            $errorList['setPeopleAccessByCpf'] = $th->getMessage();
        }

        return response()->json($actionList);
    }

}
