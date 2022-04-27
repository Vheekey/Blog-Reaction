<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    public function create(CommentRequest $request, Post $post)
    {
        Comment::create($request->validated() + [
            'post_id' => $post->id,
            'reactions' => $request->reaction
        ]);

        return response()->json([
            'message' => 'Comment Created'
        ]);
    }

    public function update(Comment $comment, CommentRequest $request)
    {
        $comment->update($request->validated());

        return response()->json([
            'message' => 'Comment Updated'
        ]);
    }

    public function delete(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'message' => 'Comment Deleted'
        ]);
    }

    public function getCommentsWithReactions(Comment $comment)
    {
        return $this->jsonResponse(200, 'Comment Retrieved', new CommentResource($comment), );
    }

    public function getPostCommentsWithReactions(Post $post)
    {
        $comments = Comment::where('post_id', $post->id)->paginate(10);

        return $this->wrapJsonResponse(CommentResource::collection($comments)->response(), 'Comments Retrieved');
    }
}
