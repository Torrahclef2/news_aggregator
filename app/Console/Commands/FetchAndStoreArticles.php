<?php
namespace App\Console\Commands;

use App\Services\NewsAggregatorService;
use Illuminate\Console\Command;

class FetchAndStoreArticles extends Command
{
    protected $signature = 'articles:fetch';
    protected $description = 'Fetch and store news articles from external APIs.';

    protected NewsAggregatorService $aggregator;

    public function __construct(NewsAggregatorService $aggregator)
    {
        parent::__construct();
        $this->aggregator = $aggregator;
    }

    public function handle()
    {
        $this->aggregator->fetchAndStoreArticles();
        $this->info('Articles fetched and stored successfully.');
    }
}
