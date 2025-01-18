<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewsAggregatorService;
use App\Models\News;
use Illuminate\Http\JsonResponse;


class NewsAggregatorController extends Controller
{
    protected $aggregator;

    public function __construct(NewsAggregatorService $aggregator)
    {
        $this->aggregator = $aggregator;
    }

    public function fetchAllNews(Request $request): JsonResponse
{
    $filters = $request->only(['category', 'source', 'from', 'to', 'keyword', 'language']);

    // If filters are empty, fetch articles from the database
    if (empty(array_filter($filters))) {
        $articles = Article::orderBy('published_at', 'desc')->get();
    } else {
        $articles = $this->aggregator->fetchAndStoreArticles($filters);
    }

    return response()->json([
        'success' => true,
        'data' => $articles,
    ]);
}



    public function fetchNewsBySource(string $source): JsonResponse
    {
        $sourceMapping = [
            'newsapi' => 'App\Services\NewsAPIService',
            'nyt' => 'App\Services\NYTService',
            'guardian' => 'App\Services\GuardianService',
        ];

        if (!array_key_exists($source, $sourceMapping)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid news source.',
            ], 400);
        }

        $serviceClass = app($sourceMapping[$source]);
        $articles = $serviceClass->fetchArticles([
            'country' => 'us',
            'category' => 'technology',
        ]);

        return response()->json([
            'success' => true,
            'data' => $articles,
        ]);
    }




    public function showNews()
    {
        $news = News::latest()->paginate(9); // Fetch latest news, 9 per page
        return view('index', compact('news'));
    }
}