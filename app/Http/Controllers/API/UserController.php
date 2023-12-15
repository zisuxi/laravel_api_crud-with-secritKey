<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserDetail()
    {
        // return  view('Api.login');
    }
    public function loginUser(Request $request)
    {
        // User::where('email', Auth::user()->email)->update([
        //     "access_token" => uniqid(),
        // ]);
        $input = $request->all();
        if (Auth::attempt($input)) {
            $user = Auth::user();
            if ($user) {
                $create_token = User::where('email', $user['email'])->update([
                    "access_token" => uniqid(),
                ]);
            }
            return response()->json(['success' => true, 'data' => $user], 200);
        } else {
            dd('Authentication failed, handle accordingly');
        }
    }

    public function userLogout(User $user)
    {
        Auth::logout();
        return response()->json([
            'status' => 200,
        ]);
    }
}
