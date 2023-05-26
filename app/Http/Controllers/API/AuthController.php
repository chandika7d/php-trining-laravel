<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;

class AuthController extends Controller
{

    public function getToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $date = new Carbon();
            $date = $date->addMinutes(Config::get('sanctum.expiration'));

            return response()->json([
                "data" => $user->createToken($user->id, ["*"], $date)
            ], 400);
        } else {
            return response()->json([
                "messages" => $validator->errors()
            ], 400);
        }
    }

}