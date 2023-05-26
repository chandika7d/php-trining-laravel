<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Color;
use Validator;

class ColorController extends Controller
{
    protected $model = Color::class;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:colors,name',
            'hex' => 'string',
            'pattern_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pattren' => 'boolean',
        ]);

        if ($validator->passes()) {
            $imageName = "";
            if ($request->pattern_image) {
                $imageName = time() . '.' . request()->pattern_image->getClientOriginalExtension();
                request()->pattern_image->move(public_path('image/colors'), $imageName);
            }

            $data = new Color;
            $data->name = $request->name;
            $data->hex = $request->hex;
            $data->pattern = $request->pattern ? true : false;
            $data->pattern_image = $imageName;
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
            'name' => 'required|unique:colors,name,'.$id,
            'hex' => 'string',
            'pattern_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pattren' => 'boolean',
        ]);

        if ($validator->passes()) {
            $data = Color::findOrFail($id);

            $imageName = $data->pattern_image;
            if ($request->pattern_image) {
                $imageName = time() . '.' . request()->pattern_image->getClientOriginalExtension();
                request()->pattern_image->move(public_path('image/colors'), $imageName);
            }

            $data->name = $request->name;
            $data->hex = $request->hex;
            $data->pattern = $request->pattern ? true : false;
            $data->pattern_image = $imageName;
            $data->save();

            return response()->json($data, 200);
        } else {
            return response()->json([
                "messages" => $validator->errors()
            ], 400);
        }
    }

}
