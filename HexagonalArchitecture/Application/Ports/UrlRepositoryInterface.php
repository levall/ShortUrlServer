<?php
namespace Application\Port;

use Application\Entity\ShortUrl;

interface UrlRepositoryInterface {
    public function save(ShortUrl $url): void;
    public function findBySlug(string $slug): ?ShortUrl;
}