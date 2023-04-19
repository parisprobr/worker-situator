<?php

namespace App\Http\Controllers;

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
            'idSituator' => $request->header('idSituator'),
            'idEs'       => $request->get('idEs'),
            'name'       => $request->get('name'),
            'active' => $request->get('active'),
            'gender' => $request->get('gender'),
            'cpf' => $request->get('cpf'),
            'document' => $request->get('document'),
            'email' => $request->get('email'),
            'personType' => $request->get('personType'),
            'phone' => $request->get('phone'),
            'phoneType' => $request->get('phoneType'),
            'observation' => $request->get('observation'),
            'birthday' => $request->get('birthday'),
            'company' => $request->get('company'),
            'duressPassword' => $request->get('duressPassword'),
            'responsible' => $request->get('responsible'),
            'accessPermission' => $request->get('accessPermission')
        ]);

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
}
