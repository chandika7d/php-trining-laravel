<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Ocassion;
use Validator;

class OcassionController extends Controller
{
    protected $model = Ocassion::class;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:ocassions,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->passes()) {
            $imageName = "";
            if ($request->image) {
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                request()->image->move(public_path('image/ocassions'), $imageName);
            }

            $data = new Ocassion;
            $data->name = $request->name;
            $data->image = $imageName;
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
            'name' => 'required|unique:ocassions,name,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->passes()) {
            $data = Ocassion::findOrFail($id);

            $imageName = $data->image;
            if ($request->image) {
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                request()->image->move(public_path('image/ocassions'), $imageName);
            }

            $data->name = $request->name;
            $data->image = $imageName;
            $data->save();

            return response()->json($data, 200);
        } else {
            return response()->json([
                "messages" => $validator->errors()
            ], 400);
        }
    }

}