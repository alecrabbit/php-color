<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Instantiator;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\RGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class RGBInstantiatorTest extends TestCase
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

    public static function canNotInstantiateRGBADataProvider(): iterable
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

    public static function canBeCreatedFromStringDataProvider(): iterable
    {
        yield from [
            ['rgb(0, 0, 0)', 0, 0, 0],
            ['rgb(0, 0, 0)', 0, 0, 0],
            ['rgb(0, 12, 33)', 0, 12, 33],
            ['rgb(0, 0, 1)', 0, 0, 1],
        ];
    }

    #[Test]
    #[DataProvider('canInstantiateRGBDataProvider')]
    public function canInstantiateRGB(int $expected, string $incoming): void
    {
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->from($incoming);
        self::assertInstanceOf(IRGBColor::class, $color);
        self::assertSame($expected, $color->getValue());
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new RGBInstantiator();
    }

    #[Test]
    #[DataProvider('canNotInstantiateRGBADataProvider')]
    public function canInstantiateRGBA(array $expected, string $incoming): void
    {
        $this->expectException(UnrecognizedColorString::class);
        $this->expectExceptionMessage(
            sprintf(
                'Unrecognized color string: "%s".',
                $incoming
            )
        );
        $instantiator = $this->getTesteeInstance();

        $instantiator->from($incoming);
    }

    #[Test]
    #[DataProvider('canBeCreatedFromStringDataProvider')]
    public function canBeCreatedFromString(string $color, int $r, int $g, int $b): void
    {
        $instantiator = $this->getTesteeInstance();
        $testee = $instantiator->from($color);
        self::assertInstanceOf(RGB::class, $testee);
        self::assertSame($r, $testee->getRed());
        self::assertSame($g, $testee->getGreen());
        self::assertSame($b, $testee->getBlue());
    }
}
