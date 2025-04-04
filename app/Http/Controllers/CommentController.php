<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'movie_id' => $request->movie_id,
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment->load(['user', 'replies'])
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['success' => false], 403);
        }

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment->load(['user', 'replies'])
        ]);
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['success' => false], 403);
        }

        $comment->delete();
        return response()->json(['success' => true]);
    }

    public function like(Comment $comment)
    {
        $like = CommentLike::firstOrCreate([
            'user_id' => Auth::id(),
            'comment_id' => $comment->id
        ]);

        if ($like->wasRecentlyCreated) {
            $comment->increment('likes_count');
        }

        return response()->json([
            'success' => true,
            'likes_count' => $comment->likes_count
        ]);
    }

    public function unlike(Comment $comment)
    {
        $like = CommentLike::where('user_id', Auth::id())
            ->where('comment_id', $comment->id)
            ->first();

        if ($like) {
            $like->delete();
            $comment->decrement('likes_count');
        }

        return response()->json([
            'success' => true,
            'likes_count' => $comment->likes_count
        ]);
    }
}
