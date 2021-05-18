<?php

declare(strict_types=1);

/*
 * This file is ...
 *
 *
 */
namespace EmagHero\Character;

/**
 * base for Character objects
 */
abstract class GameCharacterAbstract
{
    public string $characterType;
    public string $characterName;
    public array $attributes;

    public function __constructor(): void
    {
    }

    public function getType(): string
    {
        return $this->characterType;
    }

    public function getName(): string
    {
        return $this->characterName;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $attrName): float
    {
        return $this->attributes[$attrName];
    }

    public function updateAttribute(string $attrName, float $value): void
    {
        $this->attributes[$attrName] = $value;
    }

    /**
     * exports in a friendlier format for output
     */
    public function exportAttributes(): array
    {
        $attributes = $this->attributes;
        array_walk($attributes, function (&$item, $key) {
            $item = $key . ': ' . $item;
        });
        return $attributes;
    }

    /**
     * exports in a friendlier format for output
     */
    public function export(): array
    {
        return ['ATTRIBUTES:'] + $this->exportAttributes();
    }
}
