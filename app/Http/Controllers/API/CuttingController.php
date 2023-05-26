<?php

namespace App\Http\Controllers\API;

use App\Models\Cutting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CuttingController extends Controller
{

    protected $model = Cutting::class;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cuttings',
        ]);

        if ($validator->passes()) {
            $data = new Cutting;
            $data->name = $request->name;
            $data->save();

            return response()->json($data, 200);
        } else {
            return response()->json([
                "messages" => $validator->errors()
            ], 400);
        }
    }

    public function update(Request $request, string $id)
    {
       $validator = Validator::make($request->all(), [
           'name' => 'required|unique:cuttings,name,'.$id,
       ]);

       if ($validator->passes()) {
           $data = Cutting::findOrFail($id);
           $data->name = $request->name;
           $data->save();

           return response()->json($data, 200);
       } else {
           return response()->json([
               "messages" => $validator->errors()
           ], 400);
       }
    }
}
