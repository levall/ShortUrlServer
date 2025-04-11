<?php

namespace Adapters\Persistence;

// Infrastructure/Persistence/PdoUrlRepository.php
namespace Infrastructure\Persistence;

use Application\Entity\ShortUrl;
use Application\Port\UrlRepositoryInterface;

class PdoUrlRepository implements UrlRepositoryInterface {
    public function __construct() {
        //here we can implement logic of saving the URLs to the DB by PDO
        // but now we use sessions of the browsers;
        session_start();
    }

    public function save(ShortUrl $url, ): void {
        $_SESSION['url_mapping'][$url->getOriginalUrl()] = $url->getSlug();
    }

    public function findBySlug(string $slug): ?ShortUrl {

    // @todo move validation to business logic
        //    if (!empty($this->urlToShort) && filter_var($this->urlToShort, FILTER_VALIDATE_URL)) {
         //   $shortUrl = $this->generator->short();

// @todo move redirection to the correct place
//        if (isset($_SESSION['url_mapping'][$slug])) {
//            header("Location: " . $_SESSION['url_mapping'][$slug]);
//            exit;
//        }

        return $_SESSION['url_mapping'][$slug];
    }
}