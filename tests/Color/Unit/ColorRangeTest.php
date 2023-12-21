<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit;

use AlecRabbit\Color\ColorRange;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\HSL;
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
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Number of colors must be less than 1000.',
                    ],
                ],
                [
                    self::ARGUMENTS => ['#000000', '#ffffff', 2000],
                ],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Number of colors must be less than 5.',
                    ],
                ],
                [
                    self::ARGUMENTS => ['#000000', '#ffffff', 2000, 5],
                ],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Number of colors must be greater than or equal 2.',
                    ],
                ],
                [
                    self::ARGUMENTS => ['#000000', '#ffffff', 1],
                ],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Number of colors must be greater than or equal 2.',
                    ],
                ],
                [
                    self::ARGUMENTS => ['#000000', '#ffffff', -1],
                ],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Number of colors must be greater than or equal 2.',
                    ],
                ],
                [
                    self::ARGUMENTS => ['#000000', '#ffffff', 0],
                ],
            ],
            [
                [
                    self::START => $start = '#000000',
                    self::END => $end = '#ffffff',
                    self::COUNT => $count = 2,
                ],
                [
                    self::ARGUMENTS => [$start, $end, $count],
                ],
            ],
            [
                [
                    self::START => $start = HSL::fromString('hsl(0, 0%, 0%)'),
                    self::END => $end = RGB::fromString('rgb(255, 255, 255)'),
                    self::COUNT => $count = 16,
                ],
                [
                    self::ARGUMENTS => [$start, $end, $count],
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
        null|IColor|string $start = null,
        null|IColor|string $end = null,
        ?int $count = null,
        ?int $max = null,
    ): IColorRange {
        return new ColorRange(
            start: $start ?? $this->getColorMock(),
            end: $end ?? $this->getColorMock(),
            count: $count ?? 2,
            max: $max ?? 1000,
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
        self::assertEquals($expected[self::COUNT], $range->getCount());
    }
}
