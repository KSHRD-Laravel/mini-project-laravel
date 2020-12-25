<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageRestController extends Controller
{
    function storeImage(Request $request) {
        if($request->file('image')) {
            $imagePath = $request->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $path = $request->file('image')->storeAs('posts', $imageName, 'public');
            return response()->json([
                'status' => true,
                'path' => $path
            ]);
        }
    }
}
