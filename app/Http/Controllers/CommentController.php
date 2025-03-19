<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Post;

class CommentController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum')
        ];
    }

    public function store(Request $request, Post $post)
    {
        // Validate the request data (you can adjust validation rules as needed)
        $fields = $request->validate([
            'content' => 'required|string|min:3', // Comment body should be a string and at least 3 characters
        ]);

        // Create the comment and associate it with the post and the authenticated user
        $comment = $request->user()->comments()->create([
            'content' => $fields['content'], // Add the comment body
            'post_id' => $post->id, // Associate the comment with the post
        ]);

        // Return a response (could be the created comment or a success message)
        return $comment;
    }
}
