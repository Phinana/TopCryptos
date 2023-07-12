<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BlogAnswerStoreRequest;
use App\Models\Blog;
use App\Models\BlogAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogAnswerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $blogAnswers = $user->blogAnswers;

        return response()->json([
            'blogAnswers' => $blogAnswers
        ], Response::HTTP_OK);
    }

    public function store(BlogAnswerStoreRequest $request, Blog $blog)
    {
        $user = auth()->user();

        $blogAnswer = new BlogAnswer();
        $blogAnswer->content = $request->content;

        $blogAnswer->user_id = $user->id;
        $blogAnswer->blog_id = $blog->id;
        $blogAnswer->save();

        return response()->json([
            'message' => 'Blog answer created successfully',
            'blogAnswer' => $blogAnswer
        ], Response::HTTP_CREATED);
    }

    public function destroy(BlogAnswer $blogAnswer)
    {
        $user = auth()->user();

        if ($blogAnswer->user_id === $user->id) {
            $blogAnswer->delete();
            return response()->json(['message' => 'Blog answer deleted successfully'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'You are not authorized to delete this blog answer'], Response::HTTP_UNAUTHORIZED);
    }
}
