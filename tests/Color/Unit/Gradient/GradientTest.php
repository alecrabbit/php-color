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

    #[Test]
    public function canBeInstantiated(): void
    {
        $gradient = $this->getTesteeInstance();

        self::assertInstanceOf(Gradient::class, $gradient);
    }

    private function getTesteeInstance(
        ?int $maxColors = null,
        ?int $floatPrecision = null,
    ): IGradient
    {
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
    public function throwsIfCountGreaterThenMax(): void
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
    public function throwsIfCountLessThenTwo(): void
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
}
