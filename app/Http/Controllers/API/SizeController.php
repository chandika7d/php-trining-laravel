<?php

namespace App\Http\Controllers\API;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{

    protected $model = Size::class;
    protected $orderBy = ["order", "ASC"];

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sizes',
            'order' => 'required|numeric'
        ]);

        if ($validator->passes()) {

            $data = new Size;
            $data->name = $request->name;
            $data->order = $request->order;
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
            'name' => 'required|unique:sizes,name,'.$id,
            'order' => 'required|numeric'
        ]);

        if ($validator->passes()) {
            $data = Size::findOrFail($id);
            $data->name = $request->name;
            $data->order = $request->order;
            $data->save();

            return response()->json($data, 200);
        } else {
            return response()->json([
                "messages" => $validator->errors()
            ], 400);
        }
    }
}