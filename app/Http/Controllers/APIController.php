<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    public function getAllComments(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'to' => 'required',
        ]);
        if($validator->fails()) {
            return response(['error' => $validator->errors(), 'count' => 0]);
        }

        $comments = Comment::all();
        foreach ($comments as $comment) {
            $comment->clock = date_format($comment->created_at,"M d, Y \\a\\t h:ia");
            $comment->avatar = "https://ui-avatars.com/api/?background=random&name=$comment->by";
        }

        return response(['comments' => $comments, 'count' => count($comments)]);
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

        $comment->clock = date_format($comment->created_at,"M d, Y \\a\\t h:ia");
        $comment->avatar = "https://ui-avatars.com/api/?background=random&name=$comment->by";

        return response(['comment' => $comment], 200);
    }
}
