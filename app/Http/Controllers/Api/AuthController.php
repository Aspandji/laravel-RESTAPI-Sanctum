<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $token = $user->createToken('user login')->plainTextToken;

            return response()->json([
                'status_token' => 200,
                'access_token' => $token
            ]);

            // $credential = request(['email', 'password']);

            // if (!Auth::attempt($credential)) {
            //     return response()->json([
            //         'status_code' => 500,
            //         'message' => 'Anda Tidak Memiliki Hak Akses'
            //     ]);
            // }

            // $user = Auth::user();
            // $token = $user->createToken('authToken')->plainTextToken;

            // return response()->json([
            //     'status_token' => 200,
            //     'access_token' => $token
            // ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Terjadi Error',
                'error' => $e
            ]);
        }
    }
}
