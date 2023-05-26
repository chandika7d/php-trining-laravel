<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Banner;
use Validator;

class BannerController extends Controller
{
    protected $model = Banner::class;
    protected $with = ["category"];

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'unique:banners|string',
            'url' => 'nullable|string',
            'id_banner_category' => 'numeric',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->passes()) {
            $imageName = "";
            $imageName2 = "";

            if ($request->image) {
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                request()->image->move(public_path('image/banners'), $imageName);
            }

            if ($request->mobile_image) {
                $imageName2 = time() . '.' . request()->mobile_image->getClientOriginalExtension();
                request()->mobile_image->move(public_path('image/banners'), $imageName2);
            }

            $data = new Banner;
            $data->name = $request->name;
            $data->url = $request->url;
            $data->id_banner_category = $request->id_banner_category;
            $data->image = $imageName ;
            $data->mobile_image = $imageName2;
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
            'name' => 'string|unique:banners,name,'.$id,
            'url' => 'nullable|string',
            'id_banner_category' => 'number',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->passes()) {
            $data = Banner::findOrFail($id);

            $imageName = $data->image;
            $imageName2 = $data->mobile_image;

            if ($request->image) {
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                request()->image->move(public_path('image/banners'), $imageName);
            }

            if ($request->mobile_image) {
                $imageName2 = time() . '.' . request()->mobile_image->getClientOriginalExtension();
                request()->mobile_image->move(public_path('image/banners'), $imageName2);
            }

            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->id_banner_category = $request->id_banner_category;
            $data->image = $imageName ;
            $data->mobile_image = $imageName2;
            $data->save();

            return response()->json($data, 200);
        } else {
            return response()->json([
                "messages" => $validator->errors()
            ], 400);
        }
    }
}
