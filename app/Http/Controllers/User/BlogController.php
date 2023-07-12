<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BlogStoreRequest;
use App\Http\Requests\User\BlogUpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Blog;
use App\Models\Crypto;
use Carbon\Carbon;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Blog::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogStoreRequest $request)
    {
        $blog = new Blog();
        $blog->user_id = auth()->user()->id;
        $blog->title = $request->title;
        $blog->body = $request->body;

        if (!empty($request->crypto_id)) {
            $blog->crypto_id = $request->crypto_id;
            $blog->save();
            $crypto = Crypto::find($request->crypto_id);

            if ($crypto) {
                $cryptoHistories = $crypto->cryptoHistories()
                    ->where('interval', 'm10')
                    ->where('created_at', '>=', Carbon::now()->subHour())
                    ->orderBy('created_at', 'ASC')
                    ->get();

                $blog->cryptoHistories()->attach($cryptoHistories);
            }
        }else{
            $blog->save();
        }

        return response()->json([
            'message' => 'Blog created successfully',
            'blog' => $blog
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog->load('cryptoHistories', 'blogAnswers');

        return response()->json([
            'blog' => $blog
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, Blog $blog)
    {
        if ($blog->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'You are not authorized to update this blog'], Response::HTTP_UNAUTHORIZED);
        }

        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->save();

        return response()->json([
            'message' => 'Blog updated successfully',
            'blog' => $blog
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'You are not authorized to delete this blog'], Response::HTTP_UNAUTHORIZED);
        }

        $blog->delete();
        return response()->json(['message' => 'Blog deleted successfully'], Response::HTTP_OK);
    }
}
