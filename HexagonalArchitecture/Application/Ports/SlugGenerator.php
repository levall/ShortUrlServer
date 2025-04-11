<?php

// Domain/Port/SlugGeneratorInterface.php
namespace Application\Port;

interface SlugGeneratorInterface {
    public function generate(): string;
}
