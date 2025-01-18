<?php
namespace App\Jobs;

use App\Services\DataSourceFactory;
use App\Services\Parsers\ParserFactory; // Add parser factory
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchArticlesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $source;
    protected array $filters;

    public function __construct(string $source, array $filters = [])
    {
        $this->source = $source;
        $this->filters = $filters;
    }

    public function handle()
    {
        $dataSource = DataSourceFactory::make($this->source);
        $response = $dataSource->fetchArticles($this->filters);

        // Use the parser
        $parser = ParserFactory::make($this->source);
        $articles = $parser->parse($response);

        // Store articles in the database
        foreach ($articles as $article) {
            \App\Models\Article::updateOrCreate(
                ['source_id' => $article['id'], 'source' => $this->source],
                [
                    'title'       => $article['title'],
                    'content'     => $article['content'],
                    'published_at' => $article['publishedAt'],
                ]
            );
        }
    }
}
