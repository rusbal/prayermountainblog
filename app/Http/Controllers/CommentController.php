<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Comment;
use App\Http\Requests;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($nameId, Request $request)
    {
        if ($request->ajax()) {
            $result = Comment::create([
                'user_id'    => Auth::user()->id,
                'name_id'    => $nameId,
                'comment_on' => $request->comment_on,
                'comment'    => $request->comment,
            ]);

            if ($result === false) {
                return response()->json([ 'order' => 'Processing error.' ], 422);
            }

            return response()->json([ 
                'success' => true,
                'id' => $result->id,
            ], 200);
        }
    }

    public function destroy(Comment $comment, Request $request)
    {
        if ($request->ajax()) {
            $result = $comment->delete();

            if ($result === false) {
                return response()->json([ 'order' => 'Processing error.' ], 422);
            }

            return response()->json([ 'success' => true ], 200);
        }
    }
}
