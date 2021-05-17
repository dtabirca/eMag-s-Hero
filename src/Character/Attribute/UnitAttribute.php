<?php

declare(strict_types=1);

namespace EmagHero\Character\Attribute;

/**
 * creates an attribute object 
 * TODO attach Attribute objects on Character as a Collection
 */
class UnitAttribute
{
    private string $attrName;
    private int $minValue;
    private int $maxValue;

    public function __construct(array $values)
    {
        $this->attrName = $values['attrName'];
        $this->minValue = $values['minValue'];
        $this->maxValue = $values['maxValue'];
    }

    public function getName(): string
    {
        return $this->attrName;
    }

    public function getRandomValue(): int
    {
        return mt_rand($this->minValue, $this->maxValue);
    }
}
