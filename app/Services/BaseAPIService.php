<?php
namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

abstract class BaseAPIService
{
    protected function get(string $url, array $query = []): array
    {
        $response = Http::get($url, $query);

        return $response->successful() ? $response->json() : [];
    }
}