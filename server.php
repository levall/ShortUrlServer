<?php
// A simple PHP script to handle requests

// Get the requested URI


$requestUri = $_SERVER['REQUEST_URI'];
$processUrl = new URLProcessor(new GenerateUrlBy5(), $requestUri);
$processUrl->init();

/*******************************procedure implementation************************************/
/*****************************************************************************************/
/*

// In-memory store for URL mappings
session_start();


$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);


// Simple healthcheck endpoint
if ($path === '/api/ping' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode(['data' => 'pong']);
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
*/
/************************************************************************************/

/*******************************classes implementation************************************/
/*****************************************************************************************/

abstract class URLGenerator{
    public function short()
    {
    }
}

class GenerateUrlBy5 extends URLGenerator {
    public function short()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $shortUrl = '';
        for ($i = 0; $i < 5; $i++) {
            $shortUrl .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $shortUrl;
    }
}

class URLProcessor{
    public URLGenerator $generator;
    public $urlToShort;
    public $currentUrl;


    public function __construct(URLGenerator $generator, $currentUrl)
    {
        //just for store urls for current user
        session_start();
        $this->generator = $generator;
        $this->currentUrl = parse_url($currentUrl, PHP_URL_PATH);
        $this->urlToShort = $_GET['original_url'] ?? '';
    }
    public function init()
    {
       // Simple healthcheck endpoint
        if ($this->currentUrl === '/api/ping') {
            header('Content-Type: application/json');
            echo json_encode(['data' => 'pong']);
            exit;
        }

        // Create short URL endpoint
        if ($this->currentUrl === '/api/short') {

            if (!empty($this->urlToShort) && filter_var($this->urlToShort, FILTER_VALIDATE_URL)) {
                $shortUrl = $this->generator->short();
                $_SESSION['url_mapping'][$shortUrl] = $this->urlToShort;

                header('Content-Type: application/json');
                echo json_encode(['data' => ['short_url' => $this->getCurrentDomain() . $shortUrl]]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid URL']);
            }
            exit;
        }

        // Redirect endpoint for short URLs
        $path = trim($this->currentUrl, '/');

        if (isset($_SESSION['url_mapping'][$path])) {
            header("Location: " . $_SESSION['url_mapping'][$path]);
            exit;
        }

    }

    private function getCurrentDomain()
    {
        $serverName = $_SERVER['SERVER_NAME'];
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

        return $protocol . '://' . $serverName . '/';
    }
}

/**************************************************************************************************/