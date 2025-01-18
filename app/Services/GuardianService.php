<?php
namespace App\Services;
use App\Services\Contracts\NewsAPIInterface;
use Illuminate\Support\Facades\Http;

class GuardianService implements NewsAPIInterface
{
    protected string $apiKey;

    public function __construct()
    {
   //     $this->apiKey = config('services.guardian.api_key'); // Store the API key in your config/services.php
    }

    /**
     * Fetch articles from The Guardian.
     */
    public function fetchArticles(array $params = []): array
    {
        $query = [
            'api-key' => env('GUARDIAN_API_KEY'),
            'q' => $params['keyword'] ?? null,
            'from-date' => $params['from'] ?? null,
            'to-date' => $params['to'] ?? null,
            'section' => $params['category'] ?? null,
            'page-size' => 10,
        ];

        $response = Http::get('https://content.guardianapis.com/search', array_filter($query));

        if ($response->failed()) {
            return [];
        }

        $data = $response->json();

        return collect($data['response']['results'] ?? [])->map(function ($article) {
            return [
                'title' => $article['webTitle'] ?? '',
                'description' => null,
                'url' => $article['webUrl'] ?? '',
                'source' => 'The Guardian',
                'published_at' => $article['webPublicationDate'] ?? null,
                'image' => null, // The Guardian API may not provide images; adjust if necessary.
            ];
        })->toArray();
    }
}
