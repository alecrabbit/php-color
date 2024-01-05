<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit;

use AlecRabbit\Color\ColorRange;
use AlecRabbit\Color\Contract\IUnconvertibleColor;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\RGB;
use AlecRabbit\Tests\TestCase\FactoryAwareTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ColorRangeTest extends FactoryAwareTestCase
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
                    self::START => $start = HSL::fromString('hsl(0, 0%, 0%)'),
                    self::END => $end = RGB::fromString('rgb(255, 255, 255)'),
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
        null|IUnconvertibleColor|string $start = null,
        null|IUnconvertibleColor|string $end = null,
    ): IColorRange {
        return new ColorRange(
            start: $start ?? $this->getColorMock(),
            end: $end ?? $this->getColorMock(),
        );
    }

    private function getColorMock(): MockObject&IUnconvertibleColor
    {
        return $this->createMock(IUnconvertibleColor::class);
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
    }
}
