<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Gradient;


use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Gradient\Gradient;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class GradientTest extends TestCase
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
                    self::ARGUMENTS => [0],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(255, 255, 255, 1),
                ],
                [
                    self::ARGUMENTS => [99],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(85, 85, 85, 1),
                ],
                [
                    self::ARGUMENTS => [33],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(31, 31, 31, 1),
                ],
                [
                    self::ARGUMENTS => [12],
                ],
            ],
            [
                [
                    self::RESULT => RGBA::fromRGBO(201, 201, 201, 1),
                ],
                [
                    self::ARGUMENTS => [78],
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
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Index must be less than 12.',
                    ],
                ],
                [
                    self::ARGUMENTS => [15, '#000000', '#ffffff', 12],
                ],
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Index must be greater than or equal 0.',
                    ],
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

        self::assertInstanceOf(Gradient::class, $gradient);
    }

    private function getTesteeInstance(
        ?int $maxColors = null,
        ?int $floatPrecision = null,
    ): IGradient {
        return new Gradient(
            maxColors: $maxColors ?? 1000,
            floatPrecision: $floatPrecision ?? 2,
        );
    }

    #[Test]
    #[DataProvider('canProduceGradientDataProvider')]
    public function canGenerateGradientFromColors(array $expected, array $incoming): void
    {
        $generator = $this->getTesteeInstance();

        $result = $generator->create(...$incoming);

        self::assertEquals($expected, iterator_to_array($result));
    }

    #[Test]
    public function throwsIfCreateCountGreaterThenMax(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Number of colors must be less than 5.');

        $generator = $this->getTesteeInstance(
            maxColors: 5,
        );


        $result = $generator->create(
            RGBA::fromRGBO(0, 0, 0),
            RGBA::fromRGBO(255, 255, 255),
            6
        );

        // unwrap generator
        iterator_to_array($result);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfCreateCountLessThenTwo(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Number of colors must be greater than 2.');

        $generator = $this->getTesteeInstance();

        $result = $generator->create(
            RGBA::fromRGBO(0, 0, 0),
            RGBA::fromRGBO(255, 255, 255),
            1
        );

        // unwrap generator
        iterator_to_array($result);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfGetOneCountGreaterThenMax(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Number of colors must be less than 5.');

        $generator = $this->getTesteeInstance(
            maxColors: 5,
        );

        $generator->getOne(
            2,
            RGBA::fromRGBO(0, 0, 0),
            RGBA::fromRGBO(255, 255, 255),
            6
        );

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfGetOneCountLessThenTwo(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Number of colors must be greater than 2.');

        $generator = $this->getTesteeInstance();

        $generator->getOne(
            1,
            RGBA::fromRGBO(0, 0, 0),
            RGBA::fromRGBO(255, 255, 255),
            1
        );

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

        $generator = $this->getTesteeInstance();

        $args = $incoming[self::ARGUMENTS];

        $result = $generator->getOne(...$args);

        if ($expectedException) {
            self::fail(
                'Exception was not thrown.' . ' ' . $exceptionMessage
            );
        }

        self::assertEquals($expected[self::RESULT], $result, 'Actual result: '. $result->toString());
    }
}
