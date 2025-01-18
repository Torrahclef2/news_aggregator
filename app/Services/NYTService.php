<?php
namespace App\Services;

use App\Services\Contracts\NewsAPIInterface;

class NYTService extends BaseAPIService implements NewsAPIInterface
{
    public function fetchArticles(array $params = []): array
    {
        $section = $params['category'] ?? 'home';
        $query = [
            'apiKey' => env('NYT_API_KEY'),
            'q' => $params['keyword'] ?? null,
            'from' => $params['from'] ?? null,
            'to' => $params['to'] ?? null,
        ];
    
        return $this->get("https://api.nytimes.com/svc/topstories/v2/{$section}.json", array_filter($query));
    }
}
