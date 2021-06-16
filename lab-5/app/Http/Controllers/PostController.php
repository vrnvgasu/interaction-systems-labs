<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(Post::all());
    }

    public function store(PostStoreRequest $request): PostResource
    {
        $post = Post::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return new PostResource($post);
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    public function update(Request $request, $id): PostResource
    {
        $post = Post::find($id);
        $post->user_id = $request->user_id ?? $post->user_id;
        $post->title = $request->title ?? $post->title;
        $post->body = $request->body ?? $post->body;
        $post->save();

        return new PostResource($post);
    }

    public function destroy($id): JsonResponse
    {
        Post::where('id', $id)->delete();

        return response()->json($id, 202);
    }
}
