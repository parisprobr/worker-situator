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

    public function createUser(Request $request)
    {
        $request->merge([
            'idSituator' => $request->get('idSituator'),
            'idEs'       => $request->get('idEs'),
        ]);

        $request->validate([
            'idSituator' => ['required', 'Integer'],
            'idEs'       => ['required', 'Integer']
        ]);

        return response()->json([
            'createUser: ' => $this->model->createUser(
                $request->get('idSituator'),
                $request->get('idEs'),
            )
        ]);
    }

    public function getUserByName(Request $request)
    {   
        $request->merge([
            'idSituator' => $request->header('idSituator'),
            'name'       => $request->route('name'),
        ]);

        $request->validate([
            'idSituator' => ['required', 'Integer'],
            'name'       => ['required', 'String']
        ]);

        return response()->json([
            'getUserByName: ' => $this->model->getUserByName(
                $request->header('idSituator'),
                $request->route('name'),
            )
        ]);
    }
}
