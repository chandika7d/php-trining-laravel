<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\BannerCategory;
use Validator;

class BannerCategoryController extends Controller
{
    protected $model = BannerCategory::class;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:banner_categories|string',
            'description' => 'string',
        ]);

        if ($validator->passes()) {
            $data = new BannerCategory;
            $data->name = $request->name;
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
            'name' => 'string|unique:banner_categories,name,'.$id,
            'description' => 'string',
        ]);

        if ($validator->passes()) {
            $data = BannerCategory::findOrFail($id);

            $data->name = $request->name;
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
