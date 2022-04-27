<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReactionController extends Controller
{
    public function addReaction(Request $request, Comment $comment)
    {
        $this->validateReaction($request);

        $reactions = $comment->reactions ?? [];


        array_push($reactions, $request->reaction);

        $comment->update([
            'reactions' => $reactions
        ]);

        return response()->json([
            'message' => 'Reaction Added',
            'data' => new CommentResource($comment)
        ]);
    }

    public function removeReaction(Request $request, Comment $comment)
    {
        $this->validateReactionRemoval($request, $comment);

        $reactions = $comment->reactions;

        $position =  array_search($request->reaction, $reactions);

        unset($reactions[$position]);

        $comment->update([
            'reactions' => $reactions
        ]);

        return response()->json([
            'message' => 'Reaction Removed',
            'data' => new CommentResource($comment)
        ]);
    }

    protected function validateReaction(Request $request)
    {
        $request->validate([
            'reaction' => 'required|string|min:3|max:7'
        ]);
    }

    protected function validateReactionRemoval(Request $request, Comment $comment)
    {
        $request->validate([
            'reaction' => ['required', 'string', Rule::in($comment->reactions)]
        ]);
    }
}
