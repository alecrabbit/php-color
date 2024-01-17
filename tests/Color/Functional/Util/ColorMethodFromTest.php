<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Util;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHex8Color;
use AlecRabbit\Color\Contract\IHSLColor;
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
    public static function canInstantiateFromStringDataProvider(): iterable
    {
        foreach (self::canInstantiateFromStringDataFeeder() as $item) {
            yield [
                $item[0],
                $item[1],
                $item[2] ?? null,
            ];
        }
    }

    private static function canInstantiateFromStringDataFeeder(): iterable
    {
        yield from [
            // (expected)class-string, (incoming)IColor|DColor|string, (target)class-string|null
            [Hex::class, '#ff00ff'],
            [RGBA::class, 'rgba(255, 0, 255, 1)'],
            [HSL::class, 'hsl(234, 100%, 50%)'],
            [HSL::class, new DRGB(255, 0, 255), IHSLColor::class],
            [HSL::class, new DRGB(255, 0, 255), HSL::class],
            [Hex::class, new DRGB(255, 0, 255)],
            [HSLA::class, 'hsla(234, 100%, 50%, 1)'],
            [RGB::class, 'rgb(255, 0, 255)'],
            [RGB::class, RGB::fromRGB(0, 0, 0)],
            [Hex::class, RGB::fromRGB(0, 0, 0), Hex::class],
            [Hex8::class, 'rgb(255, 0, 255)', IHex8Color::class],
            [Hex8::class, 'rgb(255, 0, 255)', Hex8::class],
        ];
    }

    #[Test]
    #[DataProvider('canInstantiateFromStringDataProvider')]
    public function canInstantiateFromString(
        string $expectedClass,
        IColor|DColor|string $incoming,
        ?string $target = null
    ): void {
        $result = Color::from($incoming, $target);

        self::assertEquals($expectedClass, $result::class);
        self::assertInstanceOf($expectedClass, $result);
    }
}
