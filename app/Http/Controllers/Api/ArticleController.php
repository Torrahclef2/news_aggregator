<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    /**
     * Search articles based on query parameters.
     */
    public function search(Request $request): JsonResponse
    {
        // Retrieve search filters from the request
        $query = $request->input('query', null);
        $source = $request->input('source', null);
        $from = $request->input('from', null);
        $to = $request->input('to', null);

        // Build the query
        $articlesQuery = Article::query();

        if ($query) {
            $articlesQuery->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                  ->orWhere('description', 'LIKE', '%' . $query . '%');
            });
        }

        if ($source) {
            $articlesQuery->where('source', $source);
        }

        if ($from) {
            $articlesQuery->where('published_at', '>=', $from);
        }

        if ($to) {
            $articlesQuery->where('published_at', '<=', $to);
        }

        // Fetch and paginate results
        $articles = $articlesQuery->orderBy('published_at', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $articles,
        ]);
    }


    public function fetchByPreferences(Request $request): JsonResponse
{
    $user = $request->user();

    // Load user preferences
    $preferences = $user->preference;

    if (!$preferences) {
        return response()->json([
            'success' => false,
            'message' => 'User preferences not set.',
        ], 400);
    }

    // Build the query based on preferences
    $articlesQuery = Article::query();

    if (!empty($preferences->sources)) {
        $articlesQuery->whereIn('source', $preferences->sources);
    }

    if (!empty($preferences->categories)) {
        $articlesQuery->whereIn('category', $preferences->categories);
    }

    if (!empty($preferences->authors)) {
        $articlesQuery->whereIn('author', $preferences->authors);
    }

    // Fetch and paginate results
    $articles = $articlesQuery->orderBy('published_at', 'desc')->paginate(10);

    return response()->json([
        'success' => true,
        'data' => $articles,
    ]);
}


public function savePreferences(Request $request): JsonResponse
{
    $user = $request->user();

    $validated = $request->validate([
        'sources' => 'array|nullable',
        'categories' => 'array|nullable',
        'authors' => 'array|nullable',
    ]);

    $preferences = $user->preference()->updateOrCreate(
        ['user_id' => $user->id],
        $validated
    );

    return response()->json([
        'success' => true,
        'data' => $preferences,
    ]);
}

}
