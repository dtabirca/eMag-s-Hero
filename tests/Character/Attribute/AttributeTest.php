<?php

declare(strict_types=1);

namespace EmagHero\Tests\Character\Attribute;

use PHPUnit\Framework\TestCase;
use EmagHero\Character\Attribute\UnitAttribute;

/**
 * testing attribute object gets created and values get returned
 */
class AttributeTest extends TestCase
{
    /**
     * create attribute from array, random value should be within range
     */
    public function testAttributeInRange(): void
    {
        $minValue = 25;
        $maxValue = 45;
        $attribute = new UnitAttribute([
            'attrName' => 'testing',
            'minValue' => $minValue,
            'maxValue' => $maxValue
        ]);
        $random = $attribute->getRandomValue();

        $this->assertTrue(
            $random >= $minValue && $random <= $maxValue,
            'value not within range'
        );
    }
}
