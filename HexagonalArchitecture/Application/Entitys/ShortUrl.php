<?php

namespace Application\Entity;


class ShortUrl {
    public function __construct(
        private string $slug,
        private string $originalUrl
    ){}

    public function getSlug(): string {
        return $this->slug;
    }

    public function getOriginalUrl(): string {
        return $this->originalUrl;
    }
}
