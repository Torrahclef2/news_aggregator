<?php
namespace App\Services;

use App\Services\Contracts\NewsAPIInterface;

class NewsAPIService extends BaseAPIService implements NewsAPIInterface
{
    public function fetchArticles(array $params = []): array
    {
        $query = [
            'apiKey' => env('NEWSAPI_KEY'),
            'q' => $params['keyword'] ?? null,
            'from' => $params['from'] ?? null,
            'to' => $params['to'] ?? null,
            'language' => $params['language'] ?? 'en',
            'category' => $params['category'] ?? null,
            'pageSize' => 10,
        ];
    
        return $this->get('https://newsapi.org/v2/top-headlines', array_filter($query));
    }
}
