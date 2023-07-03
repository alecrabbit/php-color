<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Color\Instantiator;

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class HexInstantiatorTest extends TestCase
{
    public static function canInstantiateDataProvider(): iterable
    {
        yield from [
            // [(int)expected, (string)incoming]
            [0xff0000, '#ff0000'],
            [0xff0000, 'ff0000'],
            [0xffff00, '#ff0'],
            [0xffff00, 'ff0'],
            [0xfff5ee, 'seashell'],
            [0xfff5ee, 'fff5ee'],
            [0xfff5ee, '#fff5ee'],
            [0xfff5ee, 'SeaShell'],
            [0x708090, 'slategray'],
            [0x708090, 'slaTeGray'],
            [0xff0000, '#ff0000'],
            [0x0, '#000'],
            [0x0, '000'],
            [0x008080, 'teal'],
            [0xffc0cb, 'PINK'],
            [0x48D1CC, 'mediumTurquoise'],
            [0x0f0e0d, '0f0e0d'],
        ];
    }

    #[Test]
    #[DataProvider('canInstantiateDataProvider')]
    public function canInstantiate(int $expected, string $incoming): void
    {
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->fromString($incoming);
        self::assertInstanceOf(IHexColor::class, $color);
        self::assertSame($expected, $color->getValue());
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new HexInstantiator();
    }
}
