<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    //contruct
    public function __contruct()
    {
        $this->middleware(['auth']);
    }

    //store
    public function store(Post $post, Request $request)
    {
        if ($post->likedBy($request->user())) 
        {
            return response(null, 409);
        }

        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        return back();

    }

    //destroy
    public function destroy(Post $post, Request $request)
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
