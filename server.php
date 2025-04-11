<?php
// A simple PHP script to handle requests

// Get the requested URI


$requestUri = $_SERVER['REQUEST_URI'];
$processUrl = new URLProcessor(new GenerateUrlBy5(), $requestUri);
$processUrl->init();

abstract class URLGenerator{
    public function short()
    {
    }
}

class GenerateUrlBy5 extends URLGenerator {
    public function generationShortUrls()
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