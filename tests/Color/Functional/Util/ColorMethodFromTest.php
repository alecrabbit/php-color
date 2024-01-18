<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Util;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ColorMethodFromTest extends TestCase
{
    public static function canInstantiateFromDataProvider(): iterable
    {
        foreach (self::canInstantiateFromDataFeeder() as $item) {
            yield [
                $item[0], // expected
                $item[1], // incoming
            ];
        }
    }

    private static function canInstantiateFromDataFeeder(): iterable
    {
        yield from [
            // (expected)class-string<IColor>, (incoming)IColor|DColor|string
            [Hex::class, '#ff00ff'],
            [Hex8::class, '#ffffffff'],
            [RGBA::class, 'rgba(255, 0, 255, 1)'],
            [HSL::class, 'hsl(234, 100%, 50%)'],
            [Hex::class, new DRGB(255, 0, 255)],
            [HSLA::class, 'hsla(234, 100%, 50%, 1)'],
            [RGB::class, 'rgb(255, 0, 255)'],
            [RGB::class, RGB::fromRGB(0, 0, 0)],
            [HSL::class, HSL::fromHSL(0, 0, 0)],
        ];
    }

    #[Test]
    #[DataProvider('canInstantiateFromDataProvider')]
    public function canInstantiateFrom(string $expectedClass, IColor|DColor|string $incoming): void
    {
        $result = Color::from($incoming);

        self::assertEquals($expectedClass, $result::class);
    }
}
