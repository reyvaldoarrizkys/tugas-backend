<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //Tangkap Username Dan Password
        //Validate Datanya : Username Harus wajib, Password Wajib
        //Insert data ke DB

        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password'=> Hash::make($request->password)
        ];
        
        $user = User::create($input);

        $response = [
            'message' => 'User Berhasil Daftar',
        ];

        #mengirim response json
        return response()->json($response, 200);
    }

    public function login(Request $request)
    {

        $credentials = [
            'name'=> $request->name,
            'password'=> $request->password,
        ];
        
        if (Auth::attempt($credentials)) {
            #Membuat Token
            $token = Auth::user()->createToken('auth_token');

            $data = [
                'message' => 'Login Berhasil',
                'token' => $token->plainTextToken
            ];

            return response()->json($data,200);
        } else {
            $data = [
                'message' => 'Username atau Password Salah!'
            ];
            return response()->json($data,401);
        }
        
    }
    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens()->delete();
            return [
                'message' => 'Berhasil Logout, Dan Token Berhasil Dihapus!'
            ];
        } else {
            return [
                'message' => 'Tidak ditemukan pengguna yang diautentikasi',
            ];
        }
    }
}
