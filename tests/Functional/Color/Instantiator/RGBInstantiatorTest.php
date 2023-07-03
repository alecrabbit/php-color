<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Color\Instantiator;

use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class RGBInstantiatorTest extends TestCase
{
    public static function canInstantiateRGBDataProvider(): iterable
    {
        yield from [
            // [(int)expected, (string)incoming]
            [0xff0000, 'rgb(255, 0, 0)'],
            [0xff00ff, 'rgb(255, 0, 255)'],
            [0xd51e19, 'rgb(213, 30, 25)'],
            [0x0de67d, 'rgb(13, 230, 125)'],
            [0x161616, 'rgb(22, 22, 22)'],
            [0x000000, 'rgb(0, 0, 0)'],
        ];
    }

    public static function canInstantiateRGBADataProvider(): iterable
    {
        yield from [
            // [[(int)value, (float)opacity, (int)alpha]expected, (string)incoming]
            [[0xff0000, 0.0, 0], 'rgba(255, 0, 0, 0)'],
            [[0xff00ff, 0.0, 0], 'rgba(255, 0, 255, 0)'],
            [[0xff00ff, 1.0, 255], 'rgba(255, 0, 255, 1.0)'],
            [[0xd51e19, 0.0, 0], 'rgba(213, 30, 25, 0)'],
            [[0x0de67d, 0.0, 0], 'rgba(13, 230, 125, 0)'],
            [[0x0de67d, 0.498, 127], 'rgba(13, 230, 125, 0.5)'],
            [[0x161616, 0.0, 0], 'rgba(22, 22, 22, 0)'],
            [[0x000000, 0.0, 0], 'rgba(0, 0, 0, 0)'],
        ];
    }

    #[Test]
    #[DataProvider('canInstantiateRGBDataProvider')]
    public function canInstantiateRGB(int $expected, string $incoming): void
    {
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->fromString($incoming);
        self::assertInstanceOf(IRGBColor::class, $color);
        self::assertSame($expected, $color->getValue());
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new RGBInstantiator();
    }

    #[Test]
    #[DataProvider('canInstantiateRGBADataProvider')]
    public function canInstantiateRGBA(array $expected, string $incoming): void
    {
        [$value, $opacity, $alpha] = $expected;
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->fromString($incoming);
        self::assertInstanceOf(IRGBAColor::class, $color);
        self::assertSame($value, $color->getValue());
        self::assertSame($opacity, $color->getOpacity());
        self::assertSame($alpha, $color->getAlpha());
    }
}
