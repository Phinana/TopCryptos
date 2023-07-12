<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogAnswerStoreRequest;
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
        $blogAnswer->delete();
        return response()->json(['message' => 'Blog answer deleted successfully'], Response::HTTP_OK);
    }
}
