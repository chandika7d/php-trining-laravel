<?php

namespace App\Http\Controllers\API;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{

    protected $model = ProductCategory::class;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:product_categories',
        ]);

        if ($validator->passes()) {
            $data = new ProductCategory;
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
           'name' => 'required|unique:product_categories,name,'.$id,
       ]);

       if ($validator->passes()) {
           $data = ProductCategory::findOrFail($id);
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
