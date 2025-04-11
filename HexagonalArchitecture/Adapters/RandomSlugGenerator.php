<?php
// Infrastructure/Slug/RandomSlugGenerator.php
namespace Adapters\Slug;

use Application\Port\SlugGeneratorInterface;

class RandomSlugGenerator implements SlugGeneratorInterface {
    public function generate(): string {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $shortUrl = '';
        for ($i = 0; $i < 5; $i++) {
            $shortUrl .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $shortUrl;
    }
}