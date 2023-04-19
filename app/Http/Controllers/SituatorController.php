<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SituatorModel;


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
        ]);

        $request->validate([
            'idSituator' => ['required', 'Integer'],
            'idEs'       => ['required', 'Integer']
        ]);

        return response()->json([
            'response' => $this->model->createPeople(
                (int) $request->header('idSituator'),
                (int) $request->get('idEs'),
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
