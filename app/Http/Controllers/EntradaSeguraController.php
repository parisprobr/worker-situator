<?php

namespace App\Http\Controllers;

use App\Models\CredentialModel;
use App\Models\PeopleAccessModel;
use Illuminate\Http\Request;
use App\Models\SituatorModel;
use App\Models\PeopleModel;


class EntradaSeguraController extends Controller
{

    public function __construct()
    {
        
    }


    public function createPeopleWithAccess(Request $request)
    {   
        $errorList  = [];
        $actionList = [];
        $situatorController = New SituatorController();
        
        try {
            $actionList['resPeopleDelete'] = $situatorController->deletePeopleByCpf($request);
        } catch (\Throwable $th) {
            $errorList['deletePeopleByCpf'] = $th->getMessage();
        }

        try {
            $actionList['resPeopleCreate'] = $situatorController->createPeople($request);
        } catch (\Throwable $th) {
            $errorList['createPeople'] = $th->getMessage();
        }

        try {
            $actionList['resSetImage'] = $situatorController->setPeopleImage($request);
        } catch (\Throwable $th) {
            $errorList['setPeopleImage'] = $th->getMessage();
        }

        try {
            $actionList['resCreateCredential'] = $situatorController->createCredential($request);
        } catch (\Throwable $th) {
            $errorList['createCredential'] = $th->getMessage();
        }

        try {
            $resCreateCredetial = json_decode($actionList['resCreateCredential']->getContent(), true);
            $request->merge([
                'credentialId'  => $resCreateCredetial['response']['credential']['id'],
            ]);
            $actionList['setPeopleCredentialByCpf'] = $situatorController->setPeopleCredentialByCpf($request);
        } catch (\Throwable $th) {
            $errorList['setPeopleCredentialByCpf'] = $th->getMessage();
        }

        try {
            $actionList['setPeopleAccessByCpf'] = $situatorController->setPeopleAccessByCpf($request);
        } catch (\Throwable $th) {
            $errorList['setPeopleAccessByCpf'] = $th->getMessage();
        }

        return response()->json($actionList);
    }

}
