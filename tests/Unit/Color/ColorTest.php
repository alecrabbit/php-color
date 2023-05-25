<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color;

use AlecRabbit\Color\Color;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ColorTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $testee = self::getTesteeInstance();
        self::assertInstanceOf(Color::class, $testee);
    }

    protected static function getTesteeInstance(): IColor
    {
        return new Color();
    }
}
