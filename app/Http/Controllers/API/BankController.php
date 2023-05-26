<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Bank;
use Validator;

class BankController extends Controller
{
    protected $model = Bank::class;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:banks,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->passes()) {
            $imageName = "";
            if ($request->image) {
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                request()->image->move(public_path('image/banks'), $imageName);
            }

            $data = new Bank;
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
            'name' => 'required|unique:banks,name,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->passes()) {
            $data = Bank::findOrFail($id);

            $imageName = $data->image;
            if ($request->image) {
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                request()->image->move(public_path('image/banks'), $imageName);
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