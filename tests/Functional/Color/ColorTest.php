<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Color;

use AlecRabbit\Color\Color;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ColorTest extends TestCase
{
    public static function canBeCreatedFromStringDataProvider(): iterable
    {
        foreach (self::canBeCreatedFromStringDataFeeder() as $item) {
            yield [
                $item[0],
                $item[1]
            ];
        }
    }

    private static function canBeCreatedFromStringDataFeeder(): iterable
    {
        yield from [
            // (resulting)class, (incoming)value
            [Hex::class, '#ff00ff'],
            [RGBA::class, 'rgba(255, 0, 255, 1)'],
            [HSL::class, 'hsl(234, 100%, 50%)'],
            [HSLA::class, 'hsla(234, 100%, 50%, 1)'],
            [RGB::class, 'rgb(255, 0, 255)'],
        ];
    }

    #[Test]
    #[DataProvider('canBeCreatedFromStringDataProvider')]
    public function canBeCreatedFromString(string $expectedClass, string $incoming): void
    {
        $testee = self::getTesteeFromString($incoming);

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($expectedClass, $testee);
    }

    private static function getTesteeFromString(string $value): IConvertableColor
    {
        return Color::fromString($value);
    }
}
