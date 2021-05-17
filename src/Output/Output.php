<?php

declare(strict_types=1);

namespace EmagHero\Output;

interface Output
{
    public function display(array $data, string $style): void;
}
