<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Brand;
use Validator;

class BrandController extends Controller
{
    protected $model = Brand::class;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'unique:brands|string',
            'slug' => 'unique:brands|string',
            'description' => 'string',
            'photo' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'secondary_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->passes()) {
            $imageName = "";
            $imageName2 = "";

            if ($request->photo) {
                $imageName = time() . '.' . request()->photo->getClientOriginalExtension();
                request()->photo->move(public_path('image/brands'), $imageName);
            }

            if ($request->secondary_photo) {
                $imageName2 = time() . '.' . request()->secondary_photo->getClientOriginalExtension();
                request()->secondary_photo->move(public_path('image/brands'), $imageName2);
            }

            $data = new Brand;
            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->photo = $imageName ;
            $data->secondary_photo = $imageName2;
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
            'name' => 'string|unique:brands,name,'.$id,
            'slug' => 'string|unique:brands,slug,'.$id,
            'description' => 'string',
            'photo' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'secondary_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->passes()) {
            $data = Brand::findOrFail($id);

            $imageName = $data->photo;
            $imageName2 = $data->secondary_photo;

            if ($request->photo) {
                $imageName = time() . '.' . request()->photo->getClientOriginalExtension();
                request()->photo->move(public_path('image/brands'), $imageName);
            }

            if ($request->secondary_photo) {
                $imageName2 = time() . '.' . request()->secondary_photo->getClientOriginalExtension();
                request()->secondary_photo->move(public_path('image/brands'), $imageName2);
            }
            
            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->photo = $imageName ;
            $data->secondary_photo = $imageName2;
            $data->save();

            return response()->json($data, 200);
        } else {
            return response()->json([
                "messages" => $validator->errors()
            ], 400);
        }
    }
}