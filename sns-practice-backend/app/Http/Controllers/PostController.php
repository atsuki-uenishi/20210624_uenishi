<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    public function index() {
        $items = Post::with('User')->get();
        return response()->json([
            'data' => $items
        ], 200);
    }

    public function store(Request $request) {
        $item = Post::create($request->all());
        return response()->json([
            'data' => $item
        ],201);
    }

    public function show(Post $post) {
        $item = Post::with('User')->find($post);
        if($item) {
            return response()->json([
                'data' => $item
            ],200);
        } else {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
    }

    public function update(Request $request, Post $post) {
        $update = [
            'like' => $request->like,
            'like_count' => $request->like_count
        ];
        $item = Post::where('id', $post->id)->update($update);
        if($item) {
            return response()->json([
                'message' => 'Likeを更新しました'
            ],200);
        }
    }

    public function destroy(Post $post) {
        $item = Post::where('id', $post->id)->delete();
        if($item) {
            return response()->json([
                'message' => '削除しました'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found'
            ],404);
        }
    }
}
