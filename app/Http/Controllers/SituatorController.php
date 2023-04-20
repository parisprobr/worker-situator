<?php

namespace App\Http\Controllers;

use App\Models\PeopleAccessModel;
use Illuminate\Http\Request;
use App\Models\SituatorModel;
use App\Models\PeopleModel;


class SituatorController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new SituatorModel();
    }

    

    public function createPeople(Request $request)
    {   
        $request->merge([
            'idSituator' => $request->header('idSituator')
        ]);
        $request->merge($request->all());
        
        $request->validate([
            'idSituator' => ['required', 'Integer'],
            'idEs'       => ['required', 'Integer']
        ]);

        $people = new PeopleModel(
            (int) $request->get('idEs'),
            $request->get('name'),
            $request->get('active'),
            (int) $request->get('gender'),
            $request->get('cpf'),
            $request->get('document'),
            $request->get('email'),
            (int) $request->get('personType'),
            $request->get('phone'),
            (int) $request->get('phoneType'),
            $request->get('observation'),
            $request->get('birthday'),
            $request->get('company'),
            $request->get('duressPassword'),
            $request->get('responsible'),
            $request->get('accessPermission')
        );

        return response()->json([
            'response' => $this->model->createPeople(
                (int) $request->header('idSituator'),
                (int) $request->get('idEs'),
                $people
            )
        ]);
    }

    public function deletePeopleByCpf(Request $request)
    {   

        $request->merge([
            'idSituator' => $request->header('idSituator'),
            'cpf'        => $request->route('cpf'),
        ]);

        $request->validate([
            'idSituator' => ['required', 'Integer'],
            'cpf'       => ['required', 'String']
        ]);

        return response()->json([
            'response' => $this->model->deletePeopleByCpf(
                (int) $request->header('idSituator'),
                $request->route('cpf'),
            )
        ]);
    }

    public function setPeopleImage(Request $request)
    {   
        $request->merge([
            'idSituator' => $request->header('idSituator'),
            'cpf'        => $request->route('cpf'),
            'base64'        => $request->get('base64'),
        ]);
        $request->validate([
            'idSituator' => ['required', 'Integer'],
            'cpf'        => ['required', 'String'],
            'base64'     => ['required', 'String']
        ]);

        return response()->json([
            'response' => $this->model->setPeopleImage(
                (int) $request->header('idSituator'),
                $request->route('cpf'),
                $request->get('base64')  
            )
        ]);
    }

    public function getPeopleByCpf(Request $request)
    {   
        $request->merge([
            'idSituator' => $request->header('idSituator'),
            'cpf'        => $request->route('cpf'),
        ]);

        $request->validate([
            'idSituator' => ['required', 'Integer'],
            'cpf'       => ['required', 'String']
        ]);

        return response()->json([
            'response' => $this->model->getPeopleByCpf(
                (int) $request->header('idSituator'),
                $request->route('cpf'),
            )
        ]);
    }


    public function getPeopleAccessByCpf(Request $request)
    {   
        $request->merge([
            'idSituator' => $request->header('idSituator'),
            'cpf'        => $request->route('cpf'),
        ]);

        $request->validate([
            'idSituator' => ['required', 'Integer'],
            'cpf'       => ['required', 'String']
        ]);

        return response()->json([
            'response' => $this->model->getPeopleAccessByCpf(
                (int) $request->header('idSituator'),
                $request->route('cpf'),
            )
        ]);
    }

    public function deletePeopleAccessByCpf(Request $request)
    {   
        $request->merge([
            'idSituator' => $request->header('idSituator'),
            'cpf'        => $request->route('cpf'),
        ]);

        $request->validate([
            'idSituator' => ['required', 'Integer'],
            'cpf'       => ['required', 'String']
        ]);

        return response()->json([
            'response' => $this->model->deletePeopleAccessByCpf(
                (int) $request->header('idSituator'),
                $request->route('cpf'),
            )
        ]);
    }

    public function setPeopleAccessByCpf(Request $request)
    {
        $request->merge([
            'idSituator' => $request->header('idSituator'),
            'cpf'        => $request->route('cpf'),
        ]);
        $request->merge($request->all());
        
        $request->validate([
            'idSituator' => ['required', 'Integer'],
            'cpf'        => ['required', 'String']
        ]);
        $access = new PeopleAccessModel(
            (int) $request->get('pin'),
            (int) $request->get('apartment'),
            $request->get('block'),
            $request->get('administrator'),
            $request->get('startDate'),
            $request->get('validity'),
            $request->get('password'),
            (int) $request->get('parentId'),
            $request->get('imported'),
            $request->get('active'),
            (int) $request->get('type')
        );

        return response()->json([
            'response' => $this->model->setPeopleAccessByCpf(
                (int) $request->header('idSituator'),
                $request->route('cpf'),
                $access
            )
        ]);
    }

}
