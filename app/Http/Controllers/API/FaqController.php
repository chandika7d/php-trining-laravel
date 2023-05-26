<?php

namespace App\Http\Controllers\API;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{

    protected $model = Faq::class;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|unique:faqs',
            'answer' => 'required|string',
        ]);

        if ($validator->passes()) {
            $data = new Faq;
            $data->question = $request->question;
            $data->answer = $request->answer;
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
           'question' => 'required|unique:faqs,question,'.$id,
           'answer' => 'required|string',
       ]);

       if ($validator->passes()) {
           $data = Faq::findOrFail($id);
           $data->question = $request->question;
           $data->answer = $request->answer;
           $data->save();

           return response()->json($data, 200);
       } else {
           return response()->json([
               "messages" => $validator->errors()
           ], 400);
       }
    }
}
