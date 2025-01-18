<?php

namespace App\Services\Contracts;

interface NewsAPIInterface
{
    public function fetchArticles(array $params = []): array;
}