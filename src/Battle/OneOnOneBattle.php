<?php

declare(strict_types=1);

namespace EmagHero\Battle;

/**
 * defines operations in a one vs one scenario
 */
interface OneOnOneBattle extends Battle
{
    public function prefightCheck(): bool;
    public function readyPlayerOne(): void;
    public function readyPlayerTwo(): void;
}
