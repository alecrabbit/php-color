<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Util;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ColorTest extends TestCase
{
    public static function canCreateColorFromDataProvider(): iterable
    {
        foreach (self::canCreateColorFromDataFeeder() as $item) {
            yield [
                $item[0],
                $item[1]
            ];
        }
    }

    private static function canCreateColorFromDataFeeder(): iterable
    {
        yield from [
            // (resulting)class, (incoming)value
            [Hex::class, '#ff00ff'],
            [RGBA::class, 'rgba(255, 0, 255, 1)'],
            [HSL::class, 'hsl(234, 100%, 50%)'],
            [HSLA::class, 'hsla(234, 100%, 50%, 1)'],
            [RGBA::class, RGBA::from('rgba(255, 0, 255, 1)')],
            [RGB::class, 'rgb(255, 0, 255)'],
        ];
    }

    public static function canCreateColorTryFromDataProvider(): iterable
    {
        foreach (self::canCreateColorFromDataFeeder() as $item) {
            yield [
                $item[0],
                $item[1]
            ];
        }
        foreach (self::canCreateColorTryFromDataFeeder() as $item) {
            yield [
                $item[0],
                $item[1]
            ];
        }
    }

    private static function canCreateColorTryFromDataFeeder(): iterable
    {
        yield from [
            // (resulting)class, (incoming)value
            [null, 'sgda#ff00ff'],
            [null, 'rgba(255, 0, 255, 1.1'],
            [null, 'rgba(255,\ 0, 255, 1.1)'],
            [null, 'hsla(255, 0, 255, 1.1'],
        ];
    }

    #[Test]
    #[DataProvider('canCreateColorFromDataProvider')]
    public function canCreateColorFrom(string $expectedClass, mixed $incoming): void
    {
        $color = Color::from($incoming);

        if ($incoming instanceof IColor) {
            self::assertSame($incoming, $color);
        }

        self::assertEquals($expectedClass, $color::class);
    }

    #[Test]
    #[DataProvider('canCreateColorTryFromDataProvider')]
    public function canCreateColorTryFrom(?string $expectedClass, mixed $incoming): void
    {
        $color = Color::tryFrom($incoming);

        if ($incoming instanceof IColor) {
            self::assertSame($incoming, $color);
        }

        if (null === $expectedClass) {
            self::assertNull($color);
            return;
        }

        self::assertEquals($expectedClass, $color::class);
    }
}
