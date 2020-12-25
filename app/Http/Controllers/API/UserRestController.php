<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserRestController extends Controller
{
    function createUser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->name;
        $user->password = Hash::make($request->passowrd);
        $user->save();

        return response()->json([
            'user' => $user
        ]);
    }
}
