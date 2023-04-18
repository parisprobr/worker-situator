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
        $request->merge(['idEs' => $request->get('idEs')]);
        $request->validate([
            'idEs' => ['required','Integer']
        ]);

        return response()->json(['createUser: ' => $this->model->createUser($request->route('idEs'))]);
    }
}
