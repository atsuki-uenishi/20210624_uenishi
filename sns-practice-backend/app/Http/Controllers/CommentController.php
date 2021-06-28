<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Request $request) {
        $item = Comment::where('post_id', $request->post_id)->with('User')->get();
        return response()->json([
            'data' => $item
        ], 200);
    }

    public function store(Request $request) {
        $item = Comment::create($request->all());
        return response()->json([
            'data' => $item
        ],201);
    }
}
