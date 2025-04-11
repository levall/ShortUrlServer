<?php

namespace Application\Service;

use Application\Entity\ShortUrl;
use Application\Port\UrlRepositoryInterface;
use Application\Port\SlugGeneratorInterface;

class UrlShortenerService {
    public function __construct(
        private UrlRepositoryInterface $repository,
        private SlugGeneratorInterface $slugGenerator
    ) {}

    public function createShortUrl(string $originalUrl): ShortUrl {
        $slug = $this->slugGenerator->generate();
        $shortUrl = new ShortUrl($slug, $originalUrl);
        $this->repository->save($shortUrl);
        return $shortUrl;
    }

    public function getOriginalUrl(string $slug): ?string {
        $url = $this->repository->findBySlug($slug);
        return $url?->getOriginalUrl();
    }
}