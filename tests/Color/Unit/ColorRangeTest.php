<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit;

use AlecRabbit\Color\Contract\Gradient\IColorRange;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Gradient\ColorRange;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\RGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ColorRangeTest extends TestCase
{
    public static function canBeInstantiatedWithParamsDataProvider(): iterable
    {
        yield from [
            [
                [
                    self::START => $start = '#000000',
                    self::END => $end = '#ffffff',
                ],
                [
                    self::ARGUMENTS => [$start, $end],
                ],
            ],
            [
                [
                    self::START => $start = HSL::from('hsl(0, 0%, 0%)'),
                    self::END => $end = RGB::from('rgb(255, 255, 255)'),
                ],
                [
                    self::ARGUMENTS => [$start, $end],
                ],
            ],
            [
                [
                    self::START => $start = new DHSL(0, 0, 0),
                    self::END => $end = new DRGB(255, 255, 255),
                ],
                [
                    self::ARGUMENTS => [$start, $end],
                ],
            ],
            [
                [
                    self::START => $start = new DRGB(255, 255, 255),
                    self::END => $end = new DHSL(0, 0, 0),
                ],
                [
                    self::ARGUMENTS => [$start, $end],
                ],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $range = $this->getTesteeInstance();

        self::assertInstanceOf(ColorRange::class, $range);
    }

    private function getTesteeInstance(
        null|DColor|IColor|string $start = null,
        null|DColor|IColor|string $end = null,
    ): IColorRange {
        return new ColorRange(
            start: $start ?? $this->getColorMock(),
            end: $end ?? $this->getColorMock(),
        );
    }

    private function getColorMock(): MockObject&IColor
    {
        return $this->createMock(IColor::class);
    }

    #[Test]
    #[DataProvider('canBeInstantiatedWithParamsDataProvider')]
    public function canBeInstantiatedWithParams(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);
        $exceptionMessage =
            $expectedException === null ?: $expectedException->getMessage();

        if ($expectedException) {
            $this->expectException($expectedException::class);
            $this->expectExceptionMessage($exceptionMessage);
        }

        $args = $incoming[self::ARGUMENTS];

        $range = $this->getTesteeInstance(...$args);

        if ($expectedException) {
            self::fail(
                'Exception was not thrown.' . ' ' . $exceptionMessage
            );
        }
        self::assertEquals($expected[self::START], $range->getStart());
        self::assertEquals($expected[self::END], $range->getEnd());

        $continued = $range->continueWith($expected[self::START]);

        self::assertEquals($expected[self::START], $continued->getEnd());
        self::assertEquals($expected[self::END], $continued->getStart());

        $inverted = $range->invert();

        self::assertEquals($expected[self::START], $inverted->getEnd());
        self::assertEquals($expected[self::END], $inverted->getStart());
    }
}
