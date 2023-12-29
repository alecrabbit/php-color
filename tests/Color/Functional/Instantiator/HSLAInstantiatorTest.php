<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Instantiator;

use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Instantiator\HSLAInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class HSLAInstantiatorTest extends TestCase
{
    public static function canNotInstantiateHSLDataProvider(): iterable
    {
        yield from [
            // [[(int)h, (float)s, (float)l]expected, (string)incoming]
            [[22, 1.0, 0.5], 'hsl(22, 100%, 50%)'],
            [[64, 0.12, 0.14], 'hsl(64, 12%, 14%)'],
            [[0, 0.0, 0.0], 'hsl(0, 0%, 0%)'],
        ];
    }

    public static function canInstantiateHSLADataProvider(): iterable
    {
        yield from [
            // [[(int)h, (float)s, (float)l, (float)o, (int)a]expected, (string)incoming]
            [[56, 1.0, 0.5, 1.0, 255], 'hsla(56, 100%, 50%, 1)'],
            [[56, 1.0, 0.5, 1.0, 255], 'hsla(56,100%,50%,1)'],
            [[56, 1.0, 0.5, 1.0, 255], 'hsla(56, 100%,50%,1)'],
            [[56, 1.0, 0.5, 1.0, 255], 'hsla(56, 100%, 50%,1)'],
            [[56, 1.0, 0.5, 1.0, 255], 'hsla(56, 100%, 50%, 1)'],
            [[56, 1.0, 0.5, 1.0, 255], 'hsla(56, 100%,50%, 1)'],
            [[56, 1.0, 0.5, 0.0, 0], 'hsla(56, 100%, 50%, 0)'],
            [[56, 1.0, 0.0, 0.0, 0], 'hsla(56, 100%, 0%, 0)'],
            [[22, 0.0, 0.0, 0.0, 0], 'hsla(22, 0%, 0%, 0)'],
            [[33, 0.24, 0.47, 1.0, 255], 'hsla(33, 24%, 47%, 1)'],
            [[2, 0.79, 0.47, 0.0, 0], 'hsla(2, 79%, 47%, 0)'],
            [[2, 0.79, 0.47, 0.22, 56], 'hsla(2, 79%, 47%, 0.22)'],
            [[2, 0.79, 0.47, 0.21, 54], 'hsla(2, 79%, 47%, 0.21)'],
            [[2, 0.79, 0.47, 0.23, 59], 'hsla(2, 79%, 47%, 0.23)'],
        ];
    }

    #[Test]
    #[DataProvider('canNotInstantiateHSLDataProvider')]
    public function canNotInstantiateHSL(array $expected, string $incoming): void
    {
        $this->expectException(UnrecognizedColorString::class);
        $this->expectExceptionMessage(
            sprintf(
                'Unrecognized color string: "%s".',
                $incoming
            )
        );

        $instantiator = $this->getTesteeInstance();

        $instantiator->fromString($incoming);

        self::fail(sprintf('Exception was not thrown. Color: "%s".', $incoming));
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new HSLAInstantiator();
    }

    #[Test]
    #[DataProvider('canInstantiateHSLADataProvider')]
    public function canInstantiateHSLA(array $expected, string $incoming): void
    {
        [$h, $s, $l, $o, $a] = $expected;
        $instantiator = $this->getTesteeInstance();

        $color = $instantiator->fromString($incoming);
        self::assertInstanceOf(IHSLAColor::class, $color);
        self::assertSame($h, $color->getHue());
        self::assertSame($s, $color->getSaturation());
        self::assertSame($l, $color->getLightness());
        self::assertSame($o, $color->getOpacity());
        self::assertSame($a, $color->getAlpha());
    }
}
