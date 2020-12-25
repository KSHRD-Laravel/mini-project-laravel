<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryRestController extends Controller
{
    function createCategory(Request $request) {
        $validator = $request->validate([
            'name' => 'required|max:20'
        ]);
        // mass assignment
        $category= Category::create($validator);
        if($category != null) {
            return response()->json([
                'status' => true,
                'category' => $category
            ]);
        } else {
            return response()->json([
                'status' => false,
                'category' => null
            ]);
        }
    }

    function getAllCategories() {
        $categories = Category::all();
        if($categories != null) {
            return response()->json([
                'status' => true,
                'categories' => $categories
            ]);
        } else {
            return response()->json([
                'status' => false,
                'categories' => null
            ]);
        }
    }

    function getCategoryById($id) {
        $category = Category::find($id);
        foreach($category->posts as $post) {
            $post->user;
        }
        if($category != null) {
            return response()->json([
                'status' => true,
                'category' => $category
            ]);
        } else {
            return response()->json([
                'status' => false,
                'category' => null
            ]);
        }
    }

}
