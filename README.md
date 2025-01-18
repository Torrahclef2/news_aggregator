<p> Backend functionality for a news aggregator website that pulls articles from various sources and serves them to the frontend application.</p>

<b>Requirements:</b>
<br>
1. Data aggregation and storage: Implement a backend system that fetches articles from selected data sources
(choose at least 3 from the provided list) and stores them locally in a database. Ensure that the data is regularly
updated from the live data sources.
2. API endpoints: Create API endpoints for the frontend application to interact with the backend. These endpoints
should allow the frontend to retrieve articles based on search queries, filtering criteria (date, category, source), and
user preferences (selected sources, categories, authors).

<br>
<b>Data Sources That Can Be Used (Choose At Least 3)</b>
<br>
¥ NewsAPI: This is a comprehensive API that allows developers to access articles from more than 70,000 news
sources, including major newspapers, magazines, and blogs. The API provides access to articles in various
languages and categories, and it supports search and filtering
} OpenNews: This API provides access to a wide range of news content from various sources, including
newspapers, magazines, and blogs. It allows developers to retrieve articles based on keywords, categories,
and sources

{ NewsCred: The NewsCred API provides access to a wide range of news content from various sources, including
newspapers, magazines, and blogs. The API allows developers to retrieve articles based on keywords,
categories, and sources, as well as to search for articles by author, publication, and topic
 The Guardian: This API allows developers to access articles from The Guardian newspaper, one of the most
respected news sources in the world. The API provides access to articles in various categories and supports
search and filtering
u New York Times: This API allows developers to access articles from The New York Times, one of the most
respected news sources in the world. The API provides access to articles in various categories and supports
search and filtering
v BBC News: This API allows developers to access news from BBC News, one of the most trusted news sources
in the world. It provides access to articles in various categories and supports search and filtering
 NewsAPI.org: This API provides access to news articles from thousands of sources, including news
publications, blogs, and magazines. It allows developers to retrieve articles based on keywords, categories,
and sources.

1. Data aggregation and storage: Implement a backend system that fetches articles from selected data sources
(choose at least 3 from the provided list) and stores them locally in a database. Ensure that the data is regularly
updated from the live data sources.
2. API endpoints: Create API endpoints for the frontend application to interact with the backend. These endpoints
should allow the frontend to retrieve articles based on search queries, filtering criteria (date, category, source), and
user preferences (selected sources, categories, authors).


<br>




<b>Parameter	Type	        Description	                                                     Example Value</b>
  query	        String	        Search term to filter articles by title or description.	          AI
  source	    String	        Filter articles by source (e.g., newsapi, nyt, guardian).	      nyt
  from	        DateTime	    Filter articles published after this date (ISO 8601 format).	  2025-01-01T00:00:00Z
  to	        DateTime	    Filter articles published before this date (ISO 8601 format).	  2025-01-16T23:59:59Z


<b>API Example Requests</b>
a. Search Articles with a Keyword

GET /api/articles/search?query=AI

b. Search Articles by Source

GET /api/articles/search?source=nyt

c. Search Articles by Date Range

GET /api/articles/search?from=2025-01-01T00:00:00Z&to=2025-01-16T23:59:59Z

d. Combine Multiple Filters

GET /api/articles/search?query=technology&source=guardian&from=2025-01-01T00:00:00Z




<b>Run the scheduler:</b>

php artisan schedule:work

<b>Test the Workflow</b>

    Run Fetch Command:

php artisan articles:fetch

