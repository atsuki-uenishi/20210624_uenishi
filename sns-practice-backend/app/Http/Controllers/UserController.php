<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{

    public function store(Request $request) {
        $item = User::create($request->all());
        return response()->json([
            'data' => $item
        ], 201);
    }

    public function index(Request $request) {
        $item = User::where('email', $request->email)->first();
        return response()->json([
            'data' => $item
        ], 200);
    }
}
