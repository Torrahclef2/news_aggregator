<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Aggregator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Latest News</h1>
        <div class="row">
             @forelse  ($news as $article)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ Str::limit($article->description, 100) }}</p>
                            <p class="card-text">
                                <small class="text-muted">Source: {{ $article->source }}</small>
                            </p>
                            <a href="{{ $article->url }}" class="btn btn-primary btn-sm" target="_blank">Read More</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No news articles available at the moment.</p>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $news->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
