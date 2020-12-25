<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostRestController extends Controller
{
    function createPost(Request $request) {
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = $request->user_id;
        $post->image = $request->image;
        $post->save();
        $categories = $request->get('categories');
        $post->categories()->attach($categories);

        if($post != null) {
            return response()->json([
                'status' => true,
                'post' => $post
            ]);
        } else {
            return response()->json([
                'status' => false,
                'post' => null
            ]);
        }
    }

    function getAllPosts() {
        $posts = Post::all();
        foreach($posts as $post) {
            $post->user;
        }
        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);
    }

    function getPostsByPagination(Request $request) {
        $posts = Post::paginate($request->limit);
        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);
    }


    function getPostById($id) {
        $post = Post::find($id);
        $post->user;
        if($post != null) {
            return response()->json([
                'status' => true,
                'post' => $post
            ]);
        } else {
            return response()->json([
                'status' => false,
                'post' => null
            ]);
        }
    }

    function deletePostById($id) {
        $post = Post::find($id);
        if($post != null) {
            $post->delete();
            return response()->json([
                'status' => true,
                'post' => $post
            ]);
        } else {
            return response()->json([
                'status' => false,
                'post' => null
            ]);
        }
    }
}
