<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Instantiator;

use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\Instantiator\HSLAInstantiator;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HSLAInstantiatorTest extends TestCase
{
    public static function canNotInstantiateFromDColorDataProvider(): iterable
    {
        yield from [
            // [[(int)h, (float)s, (float)l]expected, (string)incoming]
            [ new DRGB(0, 0, 0)],
        ];
    }

    public static function canInstantiateFromDHSLDataProvider(): iterable
    {
        yield from [
            // [[(int)h, (float)s, (float)l, (float)o, (int)a]expected, (DColor)incoming]
            [[56, 1.0, 0.5, 1.0, 255], new DHSL(0.155555, 1.0, 0.5)],
            [[0, 0.0, 0.0, 1.0, 255], new DHSL(0, 0.0, 0.0)],
        ];
    }

    #[Test]
    #[DataProvider('canNotInstantiateFromDColorDataProvider')]
    public function canNotInstantiateHSLA(DColor $incoming): void
    {
        $this->expectException(UnsupportedValue::class);
        $this->expectExceptionMessage(
            sprintf(
                'Unsupported dto value of type "%s" provided.',
                $incoming::class
            )
        );

        $instantiator = $this->getTesteeInstance();

        $instantiator->from($incoming);

        self::fail(sprintf('Exception was not thrown. Color: "%s".', $incoming::class));
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new HSLAInstantiator();
    }

    #[Test]
    #[DataProvider('canInstantiateFromDHSLDataProvider')]
    public function canInstantiateFromDHSL(array $expected, DColor $incoming): void
    {
        [$h, $s, $l, $o, $a] = $expected;
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->from($incoming);
        self::assertInstanceOf(IHSLAColor::class, $color);
        self::assertSame($h, $color->getHue());
        self::assertSame($s, $color->getSaturation());
        self::assertSame($l, $color->getLightness());
        self::assertSame($o, $color->getOpacity());
        self::assertSame($a, $color->getAlpha());
    }
}
