<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Gradient;


use AlecRabbit\Color\ColorRange;
use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Gradient\RGBAGradient;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\FactoryAwareTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class RGBAGradientTest extends FactoryAwareTestCase
{
    public static function canProduceGradientDataProvider(): iterable
    {
        yield from [
            [
                [
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(255, 255, 255),
                ],
                ['#000', '#fff', 2],
            ],
            [
                [
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(255, 255, 255),
                ],
                ['#000', '#fff'],
            ],
            [
                [
                    RGBA::fromRGBO(0, 0, 0, 0),
                    RGBA::fromRGBO(255, 255, 255, 1),
                ],
                ['rgba(0, 0, 0, 0)', 'rgba(255, 255, 255, 1)', 2],
            ],
            [
                [
                    RGBA::fromRGBO(0, 0, 0, 0),
                    RGBA::fromRGBO(255, 255, 255, 1),
                ],
                ['rgba(0, 0, 0, 0)', 'rgba(255, 255, 255, 1)',],
            ],
            [
                [
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(128, 128, 128),
                    RGBA::fromRGBO(255, 255, 255),
                ],
                ['#000', '#fff', 3],
            ],
            [
                [
                    RGBA::fromRGBO(0, 0, 0, 0),
                    RGBA::fromRGBO(128, 128, 128, 0.5),
                    RGBA::fromRGBO(255, 255, 255, 1),
                ],
                ['rgba(0, 0, 0, 0)', RGBA::fromRGBO(255, 255, 255, 1), 3],
            ],
            [
                [
                    RGBA::fromRGBO(174, 67, 18, 1),
                    RGBA::fromRGBO(190, 54, 21, 1),
                    RGBA::fromRGBO(206, 40, 24, 1),
                    RGBA::fromRGBO(223, 27, 28, 1),
                    RGBA::fromRGBO(239, 13, 31, 1),
                    RGBA::fromRGBO(255, 0, 34, 1),

                ],
                [RGBA::fromRGBO(174, 67, 18, 1.0), '#ff0022', 6],
            ],
            [
                [
                    RGBA::fromRGBO(174, 67, 18, 0.0),
                    RGBA::fromRGBO(190, 54, 21, 0.2),
                    RGBA::fromRGBO(206, 40, 24, 0.4),
                    RGBA::fromRGBO(223, 27, 28, 0.6),
                    RGBA::fromRGBO(239, 13, 31, 0.8),
                    RGBA::fromRGBO(255, 0, 34, 1),

                ],
                ['rgba(174, 67, 18, 0)', 'rgba(255, 0, 34, 1)', 6],
            ],
            [
                [
                    RGBA::fromRGBO(0, 25, 255, 1),
                    RGBA::fromRGBO(0, 25, 255, 1),
                ],
                ['hsla(234, 100%, 50%, 1)', 'hsla(234, 100%, 50%, 1)', 2],
            ],
            [
                [
                    RGBA::fromRGBO(0, 25, 255, 1),
                    RGBA::fromRGBO(0, 25, 255, 1),
                ],
                ['hsl(234, 100%, 50%)', 'hsl(234, 100%, 50%)', 2],
            ],
            [
                [
                    RGBA::fromRGBO(0, 25, 255, 1),
                    RGBA::fromRGBO(255, 60, 0, 1),
                ],
                ['hsl(234, 100%, 50%)', 'hsl(14, 100%, 50%)', 2],
            ],
        ];
    }

    public static function canGetOneDataProvider(): iterable
    {
        yield from [
            [
                [
                    self::RESULT => RGBA::fromRGBO(255, 255, 255, 1),
                ],
                [
                    self::ARGUMENTS => [1, '#000', '#fff', 2],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(0, 0, 0, 1),
                ],
                [
                    self::ARGUMENTS => [0, '#000', '#fff', 2],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(255, 255, 255, 1),
                ],
                [
                    self::ARGUMENTS => [99, '#000', '#fff', 100],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(85, 85, 85, 1),
                ],
                [
                    self::ARGUMENTS => [33, '#000', '#fff', 100],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(31, 31, 31, 1),
                ],
                [
                    self::ARGUMENTS => [12, '#000', '#fff', 100],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(201, 201, 201, 1),
                ],
                [
                    self::ARGUMENTS => [78, '#000', '#fff', 100],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(255, 60, 0, 1),
                ],
                [
                    self::ARGUMENTS => [1, 'hsl(234, 100%, 50%)', 'hsl(14, 100%, 50%)', 2],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(255, 0, 34, 1),

                ],
                [
                    self::ARGUMENTS => [5, RGBA::fromRGBO(174, 67, 18, 1.0), '#ff0022', 6],
                ],

            ],

            [
                [
                    self::RESULT => RGBA::fromRGBO(255, 252, 244, 1),
                ],
                [
                    self::ARGUMENTS => [478, 'hsl(45, 100%, 50%)', '#fff', 500],
                ],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Number of colors must be less than 1000.',
                    ],
                ],
                [
                    self::ARGUMENTS => [1, '#000000', '#ffffff', 2000],
                ],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Number of colors must be greater than 2.',
                    ],
                ],
                [
                    self::ARGUMENTS => [1, '#000000', '#ffffff', 1],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(255, 255, 255, 1),
                ],
                [
                    self::ARGUMENTS => [15, '#000000', '#ffffff', 12],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(0, 0, 0, 1),
                ],
                [
                    self::ARGUMENTS => [-1, '#000000', '#ffffff', 12],
                ],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $gradient = $this->getTesteeInstance();

        self::assertInstanceOf(RGBAGradient::class, $gradient);
    }

    private function getTesteeInstance(
        ?IColorRange $range = null,
        ?int $count = null,
        ?int $max = null,
        ?int $precision = null,
    ): IGradient {
        return new RGBAGradient(
            range: $range ?? $this->getColorRange(),
            count: $count ?? 2,
            max: $max ?? 1000,
            precision: $precision ?? 2,
        );
    }

    private function getColorRange(): IColorRange
    {
        return new ColorRange(
            start: RGBA::fromRGBO(0, 0, 0),
            end: RGBA::fromRGBO(255, 255, 255),
        );
    }

    #[Test]
    #[DataProvider('canProduceGradientDataProvider')]
    public function canGenerateGradientFromColors(array $expected, array $incoming): void
    {
        $colorRange = new ColorRange(
            start: array_shift($incoming),
            end: array_shift($incoming),
        );

        $generator = $this->getTesteeInstance(
            range: $colorRange,
            count: array_shift($incoming),
        );

        $result = $generator->unwrap();

        self::assertEquals($expected, iterator_to_array($result));
    }

    #[Test]
    public function throwsIfGetOneCountGreaterThenMax(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Number of colors must be less than 5.');

        $generator = $this->getTesteeInstance(
            count: 6,
            max: 5,
        );

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfGetOneCountLessThenTwo(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Number of colors must be greater than 2.');

        $generator = $this->getTesteeInstance(
            count: 1,
        );

        $generator->getOne(1);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    #[DataProvider('canGetOneDataProvider')]
    public function canGetOne(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);
        $exceptionMessage =
            $expectedException === null ?: $expectedException->getMessage();

        if ($expectedException) {
            $this->expectException($expectedException::class);
            $this->expectExceptionMessage($exceptionMessage);
        }
        $args = $incoming[self::ARGUMENTS];
        $index = array_shift($args);

        $colorRange = new ColorRange(
            start: array_shift($args),
            end: array_shift($args),
        );

        $generator = $this->getTesteeInstance(
            range: $colorRange,
            count: array_shift($args),
        );

        $result = $generator->getOne($index);

        if ($expectedException) {
            self::fail(
                'Exception was not thrown.' . ' ' . $exceptionMessage
            );
        }

        self::assertEquals($expected[self::RESULT], $result, 'Actual result: ' . $result->toString());
    }
}
