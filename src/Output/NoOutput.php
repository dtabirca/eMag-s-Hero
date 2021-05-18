<?php

declare(strict_types=1);

namespace EmagHero\Output;

/**
 * silence
 */
class NoOutput implements Output
{
    public function __construct()
    {
    }

    public function display(array $data = [], $style = null): void
    {
        // silence
    }
}