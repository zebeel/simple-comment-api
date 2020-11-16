<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    public function getAllComments(Request $request) {
        return Comment::all();
    }

    public function newComment(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'by' => 'required',
            'to' => 'required',
            'content' => 'required|min:5|max:3000',
        ]);
        if($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }
        $comment = Comment::create($data);

        return response(['comment' => $comment], 200);
    }
}
