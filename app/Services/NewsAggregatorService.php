<?php
namespace App\Services;
use App\Models\Article;
use App\Services\Contracts\NewsAPIInterface;
use Carbon\Carbon;

class NewsAggregatorService
{
    // protected array $services;

    public function __construct()
    {
        $this->services = [
            app(NewsAPIService::class),
            app(NYTService::class),
            app(GuardianService::class), // Add GuardianService here
        ];
    }

    public function fetchAllArticles(array $filters = []): array
    {
        $allArticles = [];
    
        foreach ($this->services as $service) {
            if ($service instanceof NewsAPIInterface) {
                $articles = $service->fetchArticles($filters);
                $allArticles = array_merge($allArticles, $this->normalizeArticles($articles));
            }
        }
    
        // Apply additional filtering (if required)
        $allArticles = $this->applyFilters($allArticles, $filters);
    
        // Sort by published date
        usort($allArticles, function ($a, $b) {
            return strtotime($b['published_at']) - strtotime($a['published_at']);
        });
    
        return $allArticles;
    }
    
    private function applyFilters(array $articles, array $filters): array
    {
        return array_filter($articles, function ($article) use ($filters) {
            if (!empty($filters['keyword']) && stripos($article['title'], $filters['keyword']) === false) {
                return false;
            }
    
            if (!empty($filters['category']) && stripos($article['description'], $filters['category']) === false) {
                return false;
            }
    
            if (!empty($filters['source']) && stripos($article['source'], $filters['source']) === false) {
                return false;
            }
    
            if (!empty($filters['from']) && strtotime($article['published_at']) < strtotime($filters['from'])) {
                return false;
            }
    
            if (!empty($filters['to']) && strtotime($article['published_at']) > strtotime($filters['to'])) {
                return false;
            }
    
            if (!empty($filters['language']) && $article['language'] !== $filters['language']) {
                return false;
            }
    
            return true;
        });
    }

    private function normalizeArticles(array $articles): array
    {
        $normalized = [];

        foreach ($articles['articles'] ?? $articles['results'] ?? [] as $article) {
            $normalized[] = [
                'title' => $article['title'] ?? $article['headline']['main'] ?? 'No title',
                'description' => $article['description'] ?? $article['abstract'] ?? '',
                'url' => $article['url'] ?? $article['web_url'] ?? '',
                'source' => $article['source']['name'] ?? 'Unknown',
                'published_at' => $article['publishedAt'] ?? $article['pub_date'] ?? '',
                'image' => $article['urlToImage'] ?? ($article['multimedia'][0]['url'] ?? null),
            ];
        }

        return $normalized;
    }


    public function fetchAndStoreArticles(array $filters = []): array
{
    $allArticles = $this->fetchAllArticles($filters);

    foreach ($allArticles as $article) {
        Article::updateOrCreate(
            ['url' => $article['url']], // Ensure articles are unique by URL
            [
                'title' => $article['title'],
                'description' => $article['description'],
                'source' => $article['source'],
                'published_at' => Carbon::parse($article['published_at'])->format('Y-m-d H:i:s'),
                'image' => $article['image'],
            ]
        );
    }

    return $allArticles;
}
}
