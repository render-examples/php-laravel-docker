<?php

namespace App\Http\Controllers;

use App\Post;
use App\Friendship;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Post::where('user_id', $request->user()->id)->get();
    }

    public function getFriendPosts(Request $request){
        // フレンドシップのリクエストを確認
        $friendship_request = Friendship::where([
            'user_id' => $request->friend_id,
            'friend_id' => $request->user()->id,
            'status' => 'accepted'
        ])->first();
    
        // フレンドシップが承認されている場合
        if($friendship_request){
            // フレンドの投稿を取得
            $posts = Post::where('user_id', $request->friend_id)->get();
            
            // 投稿が存在すれば返す
            if($posts->isNotEmpty()){
                return response()->json($posts);
            } else {
                // 投稿がなければ空の配列を返す
                return response()->json([]);
            }
        } else {
            // フレンドシップがない場合、空の配列を返す
            return response()->json([]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "amount" => "required|string|max:255",
            "time_hour" => "required|integer|min:0|max:255",
            "time_minute" => "required|integer|min:0|max:59",
        ]);

        $post = $request->user()->posts()->create($validated);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);
        $newPost = $request->validate([
            "title" => "required|string|max:255",
            "amount" => "required|string|max:255",
            "time_hour" => "required|integer|min:0|max:255",
            "time_minute" => "required|integer|min:0|max:59",
        ]);

        $post->update($newPost);
        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);
        $post->delete();
        return ["message" => "Post deleted successfully"];
    }
}
