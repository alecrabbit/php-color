<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Gradient;


use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\IColorRange;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Gradient\ColorRange;
use AlecRabbit\Color\Gradient\HSLAGradient;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Tests\TestCase\FactoryAwareTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HSLAGradientTest extends FactoryAwareTestCase
{
    public static function canProduceGradientDataProvider(): iterable
    {
        yield from [
            [
                [
                    HSLA::fromString('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::fromString('hsla(360, 100%, 100%, 1.0)'),
                ],
                [
                    HSLA::fromString('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::fromString('hsla(360, 100%, 100%, 1.0)'),
                    2
                ],
            ],
            [
                [
                    HSLA::fromString('hsla(0, 0%, 0%, 1.0)'),
                    HSLA::fromString('hsla(0, 0%, 100%, 1.0)'),
                ],
                ['#000', '#fff'],
            ],
            [
                [
                    HSLA::fromString('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::fromString('hsla(0, 0%, 100%, 1.0)'),
                ],
                ['rgba(0, 0, 0, 0)', 'rgba(255, 255, 255, 1)', 2],
            ],
            [
                [
                    HSLA::fromString('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::fromString('hsla(0, 0%, 100%, 1.0)'),
                ],
                ['rgba(0, 0, 0, 0)', 'rgba(255, 255, 255, 1)',],
            ],
            [
                [
                    HSLA::fromString('hsla(0, 0%, 0%, 1.0)'),
                    HSLA::fromString('hsla(0, 0%, 50%, 1.0)'),
                    HSLA::fromString('hsla(0, 0%, 100%, 1.0)'),
                ],
                ['#000', '#fff', 3],
            ],
            [
                [
                    HSLA::fromString('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::fromString('hsla(180, 50%, 50%, 0.5)'),
                    HSLA::fromString('hsla(360, 100%, 100%, 1.0)'),
                ],
                [
                    HSLA::fromString('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::fromString('hsla(360, 100%, 100%, 1.0)'),
                    3
                ],
            ],
            [
                [
                    HSLA::fromString('hsla(0, 100%, 50%, 1.0)'),
                    HSLA::fromString('hsla(180, 100%, 50%, 1.0)'),
                    HSLA::fromString('hsla(360, 100%, 50%, 1.0)'),
                ],
                [
                    HSLA::fromString('hsla(0, 100%, 50%)'),
                    HSLA::fromString('hsla(360, 100%, 50%)'),
                    3
                ],
            ],
            [
                [
                    HSLA::fromString('hsla(0, 100%, 50%, 1.0)'),
                    HSLA::fromString('hsla(120, 100%, 50%, 1.0)'),
                    HSLA::fromString('hsla(240, 100%, 50%, 1.0)'),
                    HSLA::fromString('hsla(360, 100%, 50%, 1.0)'),
                ],
                [
                    HSLA::fromString('hsla(0, 100%, 50%)'),
                    HSLA::fromString('hsla(360, 100%, 50%)'),
                    4
                ],
            ],
            [
                [
                    HSLA::fromString('hsla(0, 0%, 50%, 1)'),
                    HSLA::fromString('hsla(5, 1%, 50%, 1)'),
                    HSLA::fromString('hsla(9, 3%, 50%, 1)'),
                    HSLA::fromString('hsla(14, 4%, 50%, 1)'),
                    HSLA::fromString('hsla(19, 5%, 50%, 1)'),
                    HSLA::fromString('hsla(24, 7%, 50%, 1)'),
                    HSLA::fromString('hsla(28, 8%, 50%, 1)'),
                    HSLA::fromString('hsla(33, 9%, 50%, 1)'),
                    HSLA::fromString('hsla(38, 11%, 50%, 1)'),
                    HSLA::fromString('hsla(43, 12%, 50%, 1)'),
                    HSLA::fromString('hsla(47, 13%, 50%, 1)'),
                    HSLA::fromString('hsla(52, 14%, 50%, 1)'),
                    HSLA::fromString('hsla(57, 16%, 50%, 1)'),
                    HSLA::fromString('hsla(62, 17%, 50%, 1)'),
                    HSLA::fromString('hsla(66, 18%, 50%, 1)'),
                    HSLA::fromString('hsla(71, 20%, 50%, 1)'),
                    HSLA::fromString('hsla(76, 21%, 50%, 1)'),
                    HSLA::fromString('hsla(81, 22%, 50%, 1)'),
                    HSLA::fromString('hsla(85, 24%, 50%, 1)'),
                    HSLA::fromString('hsla(90, 25%, 50%, 1)'),
                    HSLA::fromString('hsla(95, 26%, 50%, 1)'),
                    HSLA::fromString('hsla(99, 28%, 50%, 1)'),
                    HSLA::fromString('hsla(104, 29%, 50%, 1)'),
                    HSLA::fromString('hsla(109, 30%, 50%, 1)'),
                    HSLA::fromString('hsla(114, 32%, 50%, 1)'),
                    HSLA::fromString('hsla(118, 33%, 50%, 1)'),
                    HSLA::fromString('hsla(123, 34%, 50%, 1)'),
                    HSLA::fromString('hsla(128, 36%, 50%, 1)'),
                    HSLA::fromString('hsla(133, 37%, 50%, 1)'),
                    HSLA::fromString('hsla(137, 38%, 50%, 1)'),
                    HSLA::fromString('hsla(142, 39%, 50%, 1)'),
                    HSLA::fromString('hsla(147, 41%, 50%, 1)'),
                    HSLA::fromString('hsla(152, 42%, 50%, 1)'),
                    HSLA::fromString('hsla(156, 43%, 50%, 1)'),
                    HSLA::fromString('hsla(161, 45%, 50%, 1)'),
                    HSLA::fromString('hsla(166, 46%, 50%, 1)'),
                    HSLA::fromString('hsla(171, 47%, 50%, 1)'),
                    HSLA::fromString('hsla(175, 49%, 50%, 1)'),
                    HSLA::fromString('hsla(180, 50%, 50%, 1)'),
                    HSLA::fromString('hsla(185, 51%, 50%, 1)'),
                    HSLA::fromString('hsla(189, 53%, 50%, 1)'),
                    HSLA::fromString('hsla(194, 54%, 50%, 1)'),
                    HSLA::fromString('hsla(199, 55%, 50%, 1)'),
                    HSLA::fromString('hsla(204, 57%, 50%, 1)'),
                    HSLA::fromString('hsla(208, 58%, 50%, 1)'),
                    HSLA::fromString('hsla(213, 59%, 50%, 1)'),
                    HSLA::fromString('hsla(218, 61%, 50%, 1)'),
                    HSLA::fromString('hsla(223, 62%, 50%, 1)'),
                    HSLA::fromString('hsla(227, 63%, 50%, 1)'),
                    HSLA::fromString('hsla(232, 64%, 50%, 1)'),
                    HSLA::fromString('hsla(237, 66%, 50%, 1)'),
                    HSLA::fromString('hsla(242, 67%, 50%, 1)'),
                    HSLA::fromString('hsla(246, 68%, 50%, 1)'),
                    HSLA::fromString('hsla(251, 70%, 50%, 1)'),
                    HSLA::fromString('hsla(256, 71%, 50%, 1)'),
                    HSLA::fromString('hsla(261, 72%, 50%, 1)'),
                    HSLA::fromString('hsla(265, 74%, 50%, 1)'),
                    HSLA::fromString('hsla(270, 75%, 50%, 1)'),
                    HSLA::fromString('hsla(275, 76%, 50%, 1)'),
                    HSLA::fromString('hsla(279, 78%, 50%, 1)'),
                    HSLA::fromString('hsla(284, 79%, 50%, 1)'),
                    HSLA::fromString('hsla(289, 80%, 50%, 1)'),
                    HSLA::fromString('hsla(294, 82%, 50%, 1)'),
                    HSLA::fromString('hsla(298, 83%, 50%, 1)'),
                    HSLA::fromString('hsla(303, 84%, 50%, 1)'),
                    HSLA::fromString('hsla(308, 86%, 50%, 1)'),
                    HSLA::fromString('hsla(313, 87%, 50%, 1)'),
                    HSLA::fromString('hsla(317, 88%, 50%, 1)'),
                    HSLA::fromString('hsla(322, 89%, 50%, 1)'),
                    HSLA::fromString('hsla(327, 91%, 50%, 1)'),
                    HSLA::fromString('hsla(332, 92%, 50%, 1)'),
                    HSLA::fromString('hsla(336, 93%, 50%, 1)'),
                    HSLA::fromString('hsla(341, 95%, 50%, 1)'),
                    HSLA::fromString('hsla(346, 96%, 50%, 1)'),
                    HSLA::fromString('hsla(351, 97%, 50%, 1)'),
                    HSLA::fromString('hsla(355, 99%, 50%, 1)'),
                    HSLA::fromString('hsla(360, 100%, 50%, 1)'),
                ],
                [
                    HSLA::fromString('hsla(0, 0%, 50%)'),
                    HSLA::fromString('hsla(360, 100%, 50%)'),
                    77,
                ],
            ],
        ];
    }

    public static function canGetOneDataProvider(): iterable
    {
        yield from [
            [
                [
                    self::RESULT => HSLA::fromString('hsla(0, 0%, 100%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [1, '#000', '#fff', 2],
                ],
            ],
            [
                [
                    self::RESULT => HSLA::fromString('hsla(0, 0%, 0%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [0, '#000', '#fff', 2],
                ],
            ],
            [
                [
                    self::RESULT => HSLA::fromString('hsla(0, 0%, 100%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [99, '#000', '#fff', 100],
                ],
            ],
            [
                [
                    self::RESULT => HSLA::fromString('hsla(0, 0%, 33%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [33, '#000', '#fff', 100],
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
                    self::RESULT => HSLA::fromString('hsla(0, 0%, 100%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [15, '#000000', '#ffffff', 12],
                ],
            ],
            [
                [
                    self::RESULT => HSLA::fromString('hsla(0, 0%, 0%, 1.0)'),
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

        self::assertInstanceOf(HSLAGradient::class, $gradient);
    }

    private function getTesteeInstance(
        ?IColorRange $range = null,
        ?int $count = null,
        ?int $max = null,
        ?int $precision = null,
    ): IGradient {
        return new HSLAGradient(
            range: $range ?? $this->getColorRange(),
            count: $count ?? 2,
            max: $max ?? 1000,
            precision: $precision ?? 2,
        );
    }

    private function getColorRange(): IColorRange
    {
        return new ColorRange(
            start: HSLA::fromHSL(0),
            end: HSLA::fromHSL(360),
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

        $count = array_shift($incoming) ?? 2;

        $gradient = $this->getTesteeInstance(
            range: $colorRange,
            count: $count,
        );

        $result = iterator_to_array($gradient->unwrap());

        self::assertEquals($expected, $result);
        self::assertCount($count, $result);
        self::assertEquals($count, $gradient->getCount());
    }

    #[Test]
    public function throwsIfGetOneCountGreaterThenMax(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Number of colors must be less than 5.');

        $gradient = $this->getTesteeInstance(
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

        $gradient = $this->getTesteeInstance(
            count: 1,
        );

        $gradient->getOne(1);

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

        $gradient = $this->getTesteeInstance(
            range: $colorRange,
            count: array_shift($args),
        );

        $result = $gradient->getOne($index);

        if ($expectedException) {
            self::fail(
                'Exception was not thrown.' . ' ' . $exceptionMessage
            );
        }

        self::assertEquals($expected[self::RESULT], $result, 'Actual result: ' . $result->toString());
    }
}
