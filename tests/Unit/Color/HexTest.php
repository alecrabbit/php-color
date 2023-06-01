<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\RGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class HexTest extends TestCase
{
    public static function canBeCreatedFromIntegerDataProvider(): iterable
    {
        foreach (self::canBeCreatedFromIntegerDataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $resulting[0],
                        self::RED => $resulting[1],
                        self::GREEN => $resulting[2],
                        self::BLUE => $resulting[3],
                    ]
                ],
                [
                    self::VALUE => $incoming[0],
                ]
            ];
        }
    }

    private static function canBeCreatedFromIntegerDataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, r, g, b], (incoming)[value]
            [[0xFF00FF, 0xFF, 0x00, 0xFF,], [0xFF00FF]],
        ];
    }

      #[Test]
    #[DataProvider('canBeCreatedFromIntegerDataProvider')]
    public function canBeCreatedFromInteger(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $value = $incoming[self::VALUE];
        $testee = self::getTesteeFromInteger($value);
//        self::assertSame($result[self::RED], $testee->getRed());
//        self::assertSame($result[self::GREEN], $testee->getGreen());
//        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::VALUE], $testee->getValue());
    }

    private static function getTesteeFromInteger(int $value): IHexColor
    {
        return Hex::fromInteger($value);
    }

}
