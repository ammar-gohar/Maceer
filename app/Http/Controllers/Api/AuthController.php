<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $creds = $request->validate([
            'national_id' => 'required|bail|exists:users,national_id|digits:14',
            'password'    => 'required|bail|min:8',
        ]);

        if(!Auth::attempt($creds)){
            return response()->json(['message' => 'The credentails do not match any of our records'], 401);
        };

        $user = User::where('national_id', $creds['national_id'])->firstOrFail();

        $token = $user->createToken('Token for User'. $user->national_id)->plainTextToken;

        return response()->json(['token' => $token], 200);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Goodbye!'], 200);
    }

}
