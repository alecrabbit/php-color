<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Util;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ColorTest extends TestCase
{
    public static function canCreateColorFromDataProvider(): iterable
    {
        yield from self::canCreateColorFromDataFeeder();
    }

    private static function canCreateColorFromDataFeeder(): iterable
    {
        yield from [
            [RGBA::class, '#ff00ff'],
            [RGBA::class, 'rgba(255, 0, 255, 1)'],
            [HSLA::class, 'hsl(234, 100%, 50%)'],
            [HSLA::class, 'hsla(234, 100%, 50%, 1)'],
            [RGBA::class, RGBA::from('rgba(255, 0, 255, 1)')],
            [RGB::class, RGB::from('rgba(255, 0, 255, 1)')],
            [Hex::class, Hex::from('rgba(255, 0, 255, 1)')],
            [Hex8::class, Hex8::from('rgba(255, 0, 255, 1)')],
            [HSL::class, HSL::from('hsla(255 0% 50% / 1)')],
            [HSLA::class, HSLA::from('hsla(255 0% 50% / 1)')],
            [RGBA::class, 'rgb(255, 0, 255)'],
        ];
    }

    public static function canCreateColorTryFromDataProvider(): iterable
    {
        yield from self::canCreateColorFromDataFeeder();
        yield from self::canCreateColorTryFromDataFeeder();
    }

    private static function canCreateColorTryFromDataFeeder(): iterable
    {
        yield from [
            [null, 'sgda#ff00ff'],
            [null, 'rgba(255, 0, 255, 1.1'],
            [null, 'rgba(255,\ 0, 255, 1.1)'],
            [null, 'rgb(255,\ 0, 255, 1.1)'],
            [null, 'hsla(255, 0, 255, 1.1'],
            [null, 'hsl(255, 0, 255, 1.1'],
            [null, 'hsla(255 0% 50% \ 1)'],
        ];
    }

    public static function throwsIfValueIsInvalidDataProvider(): iterable
    {
        yield from [
            [1],
            [1.1],
            [new stdClass()],
            [null],
            [false],
            [true],
            [0],
            [0.0],
            [''],
            [' '],
            ['rgba(255, 0, 255, 1.1'],
            ['rgb255, 0, 255, 1.1)'],
            ['hsla(255, 0, 255, 1.1'],
            ['hsl(255, 0, 255, 1.1'],
            ['hsla(255 0% 50% \ 1)'],
        ];
    }

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
            [RGBA::class, '#ff00ff'],
            [RGBA::class, '#ffffffff'],
            [RGBA::class, 'rgba(255, 0, 255, 1)'],
            [HSLA::class, 'hsl(234, 100%, 50%)'],
            [RGBA::class, new DRGB(255, 0, 255)],
            [HSLA::class, new DHSL(0, 0, 0)],
            [HSLA::class, 'hsla(234, 100%, 50%, 1)'],
            [RGBA::class, 'rgb(255, 0, 255)'],
            [RGB::class, RGB::fromRGB(0, 0, 0)],
            [HSL::class, HSL::fromHSL(0, 0, 0)],
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

    #[Test]
    #[DataProvider('canInstantiateFromDataProvider')]
    public function canInstantiateFrom(string $expectedClass, IColor|DColor|string $incoming): void
    {
        $result = Color::from($incoming);

        self::assertEquals($expectedClass, $result::class);
    }

    #[Test]
    #[DataProvider('throwsIfValueIsInvalidDataProvider')]
    public function throwsIfValueIsInvalid(mixed $input): void
    {
        $this->expectException(UnsupportedValue::class);

        Color::from($input);

        self::fail('Exception was not thrown.');
    }
}
