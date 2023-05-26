<?php

namespace App\Http\Controllers\API;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{

    protected $model = Config::class;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:configs',
            'nilai1' => 'nullable|string',
            'nilai2' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->passes()) {
            $data = new Config;
            $data->name = $request->name;
            $data->nilai1 = $request->nilai1;
            $data->nilai2 = $request->nilai2;
            $data->description = $request->description;
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
           'name' => 'required|unique:configs,name,'.$id,
           'nilai1' => 'nullable|string',
           'nilai2' => 'nullable|string',
           'description' => 'nullable|string',
       ]);

       if ($validator->passes()) {
           $data = Config::findOrFail($id);
           $data->name = $request->name;
           $data->nilai1 = $request->nilai1;
           $data->nilai2 = $request->nilai2;
           $data->description = $request->description;
           $data->save();

           return response()->json($data, 200);
       } else {
           return response()->json([
               "messages" => $validator->errors()
           ], 400);
       }
    }
}
