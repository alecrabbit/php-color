<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Util;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ColorFromMethodTest extends TestCase
{
    public static function canInstantiateFromStringDataProvider(): iterable
    {
        foreach (self::canInstantiateFromStringDataFeeder() as $item) {
            yield [
                $item[0],
                $item[1]
            ];
        }
    }

    private static function canInstantiateFromStringDataFeeder(): iterable
    {
        yield from [
            // (resulting)class, (incoming)value
            [Hex::class, '#ff00ff'],
            [RGBA::class, 'rgba(255, 0, 255, 1)'],
            [HSL::class, 'hsl(234, 100%, 50%)'],
            [HSLA::class, 'hsla(234, 100%, 50%, 1)'],
            [RGB::class, 'rgb(255, 0, 255)'],
//            [Hex8::class, 'rgb(255, 0, 255)', IHex8Color::class],
//            [Hex8::class, 'rgb(255, 0, 255)', Hex8::class],
        ];
    }

    #[Test]
    #[DataProvider('canInstantiateFromStringDataProvider')]
    public function canInstantiateFromString(
        string $expectedClass,
        IColor|DColor|string $incoming,
        ?string $target = null
    ): void {
        self::assertInstanceOf($expectedClass, Color::from($incoming, $target));
    }
}
