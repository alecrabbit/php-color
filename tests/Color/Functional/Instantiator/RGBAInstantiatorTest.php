<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Instantiator;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\Instantiator\RGBAInstantiator;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class RGBAInstantiatorTest extends TestCase
{
    public static function canNotInstantiateFromDColorDataProvider(): iterable
    {
        yield from [
            // [ (DColor)incoming]
            [new DHSL(0, 0, 0)],
        ];
    }

    public static function canInstantiateFromDRGBDataProvider(): iterable
    {
        yield from [
            // [[(int)value, (float)opacity, (int)alpha]expected, (string)incoming]
            [[0xff0000, 0.0, 0], new DRGB(1, 0, 0, 0)],
        ];
    }

    #[Test]
    #[DataProvider('canNotInstantiateFromDColorDataProvider')]
    public function canInstantiateRGB(DColor $incoming): void
    {
        $this->expectException(UnsupportedValue::class);
        $this->expectExceptionMessage(
            sprintf(
                'Unsupported dto value of type "%s" provided.',
                $incoming::class
            )
        );

        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->from($incoming);
        self::assertInstanceOf(IRGBAColor::class, $color);
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new RGBAInstantiator();
    }

    #[Test]
    #[DataProvider('canInstantiateFromDRGBDataProvider')]
    public function canInstantiateFromDRGB(array $expected, DColor $incoming): void
    {
        [$value, $opacity, $alpha] = $expected;
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->from($incoming);
        self::assertInstanceOf(IRGBAColor::class, $color);
        self::assertSame($value, $color->getValue());
        self::assertSame($opacity, $color->getOpacity());
        self::assertSame($alpha, $color->getAlpha());
    }
}
