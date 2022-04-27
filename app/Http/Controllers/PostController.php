<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(CreatePostRequest $request)
    {
        Post::create($request->validated());

        return response()->json([
            'message' => 'Post Created'
        ]);
    }

    public function update(Post $post, CreatePostRequest $request)
    {
        $post->update($request->validated());

        return response()->json([
            'message' => 'Post Updated'
        ]);
    }

    public function delete(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Post Deleted'
        ]);
    }

    public function getUserPosts()
    {
        $user_posts =  guestUser()->with('posts','posts.comments')->paginate(10);

        $user_posts = new JsonResponse($user_posts);

        return $this->wrapJsonResponse($user_posts, 'Posts Retrieved');
    }

    public function getSinglePost(Post $post)
    {
        return response()->json([
            'message' => 'Post Retrieved',
            'data' => $post
        ]);
    }
}
