<?php
// Get the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

// In-memory store for URL mappings
session_start();


$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);


// Simple healthcheck endpoint
if ($path === '/api/ping' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode(['data' => 'pong'] );
    exit;
}

// Create short URL endpoint
if ($path === '/api/short' && $_SERVER['REQUEST_METHOD'] === 'GET') {

if (isset($_GET['original_url']) && filter_var($_GET['original_url'], FILTER_VALIDATE_URL)) {
    $original_url = $_GET['original_url'];
    $short_url = generateShortUrl();
    $_SESSION['url_mapping'][$short_url] = $original_url;

    header('Content-Type: application/json');
        echo json_encode(['data' => ['short_url' => "http://localhost:8000/$short_url"]]);
    } else {
         http_response_code(400);
         echo json_encode(['error' => 'Invalid URL']);
    }
    exit;
}

// Redirect endpoint for short URLs
$path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');


if (isset($_SESSION['url_mapping'][$path])) {
    header("Location: " . $_SESSION['url_mapping'][$path]);
    exit;
}

// If no endpoint matches, return 404
http_response_code(404);
echo "404 Not Found";

// Function to generate a short URL (5-character random string)
function generateShortUrl() {
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $short_url = '';

    for ($i = 0; $i < 5; $i++) {
        $short_url .= $characters[rand(0, strlen($characters) - 1)];
    }
return $short_url;
}

/************************************************************************************/