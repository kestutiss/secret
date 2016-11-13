<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Secret;
use App\Transformers\SecretTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class SecretController extends Controller
{
    protected static $secretValidationRules = [
        'name'          => 'required|string|unique:secrets.name',
        'latitude'      => 'required|numeric',
        'longitude'     => 'required|numeric',
        'location_name' => 'required|string'
    ];

    public function index(Manager $fractal, SecretTransformer $secretTransformer, Request $request)
    {
        $records = Secret::all();

        $collection = new Collection($records, $secretTransformer);

        $data = $fractal->createData($collection)->toArray();

        return response()->json($data);
    }

    public function get($id)
    {
        return response()->json(['method' => 'get', 'id' => $id]);
    }

    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'          => 'required|string|unique:secrets,name',
                'latitude'      => 'required|numeric',
                'longitude'     => 'required|numeric',
                'location_name' => 'required|string'
            ]
        );

        $secret = Secret::create($request->all());

        if ($secret->save() === false) {
            // Manage error
        }

        return response()->json(['method' => 'create']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['method' => 'update', 'id' => $id]);
    }

    public function delete($id)
    {
        return response()->json(['method' => 'delete', 'id' => $id]);
    }
}
