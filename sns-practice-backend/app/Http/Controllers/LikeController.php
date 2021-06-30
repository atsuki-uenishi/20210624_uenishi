<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Like;

class LikeController extends Controller
{
    public function store(Request $request) {
        $item = Like::create($request->all());
        $likeCount = count(Like::where('post_id', $request->post_id)->get());
        return response()->json([
            'data' => $item,
            'likeCount' => $likeCount
        ], 201);
    }
    public function destroy(Like $like) {
        $item = Like::where('id', $like->id)->delete();
        if($item) {
            return response()->json([
                'message' => 'Delete',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
    }
    public function index(Request $request) {
        $item = Like::where('user_id', $request->user_id)->where('post_id', $request->post_id)->first();
        $likeCount = count(Like::where('post_id', $request->post_id)->get());
        if($item || $likeCount) {
            return response()->json([
                'data' => $item,
                'like' => $likeCount
            ], 200);
        }
    }

}
