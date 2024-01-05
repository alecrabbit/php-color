<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Instantiator;

use AlecRabbit\Color\Contract\IHex8Color;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Instantiator\Hex8Instantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class Hex8InstantiatorTest extends TestCase
{
    public static function canInstantiateDataProvider(): iterable
    {
        yield from [
            // [(int)value, (int)alpha, (string)incoming]
            [0x0, 0x00, '#0000'],
            [0x0, 0x00, '0000'],
            [0xff0000, 0x00, '#ff000000'],
            [0xff0000, 0xff, 'ff0000ff'],
            [0xff00a0, 0x00, 'fF00A000'],
            [0xffff00, 0xdd, '#ff0d'],
            [0xffff00, 0x00, 'ff00'],
            [0xfff5ee, 0x00, 'fff5ee00'],
            [0xfff5ee, 0x00, '#fff5ee00'],
            [0xff0000, 0x14, '#ff000014'],
            [0x008080, 0x02, '#00808002'],
        ];
    }

    #[Test]
    #[DataProvider('canInstantiateDataProvider')]
    public function canInstantiate(int $value, int $alpha, string $incoming): void
    {
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->fromString($incoming);
        self::assertInstanceOf(IHex8Color::class, $color);
        self::assertSame($value, $color->getValue());
        self::assertSame($alpha, $color->getAlpha());
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new Hex8Instantiator();
    }
}
