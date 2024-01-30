<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Gradient;


use AlecRabbit\Color\Contract\Gradient\IColorRange;
use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Gradient\ColorRange;
use AlecRabbit\Color\Gradient\HSLAGradient;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HSLAGradientTest extends TestCase
{
    public static function canProduceGradientDataProvider(): iterable
    {
        yield from [
            [
                [
                    HSLA::from('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::from('hsla(360, 100%, 100%, 1.0)'),
                ],
                [
                    HSLA::from('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::from('hsla(360, 100%, 100%, 1.0)'),
                    2
                ],
            ],
            [
                [
                    HSLA::from('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::from('hsla(360, 100%, 100%, 1.0)'),
                ],
                [
                    new DHSL(0, 0, 0, 0),
                    new DHSL(1, 1, 1, 1),
                    2
                ],
            ],
            [
                [
                    HSLA::from('hsla(0, 0%, 0%, 1.0)'),
                    HSLA::from('hsla(0, 0%, 100%, 1.0)'),
                ],
                ['#000', '#fff'],
            ],
            [
                [
                    HSLA::from('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::from('hsla(0, 0%, 100%, 1.0)'),
                ],
                ['rgba(0, 0, 0, 0)', 'rgba(255, 255, 255, 1)', 2],
            ],
            [
                [
                    HSLA::from('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::from('hsla(0, 0%, 100%, 1.0)'),
                ],
                ['rgba(0, 0, 0, 0)', 'rgba(255, 255, 255, 1)',],
            ],
            [
                [
                    HSLA::from('hsla(0, 0%, 0%, 1.0)'),
                    HSLA::from('hsla(0, 0%, 50%, 1.0)'),
                    HSLA::from('hsla(0, 0%, 100%, 1.0)'),
                ],
                ['#000', '#fff', 3],
            ],
            [
                [
                    HSLA::from('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::from('hsla(180, 50%, 50%, 0.5)'),
                    HSLA::from('hsla(360, 100%, 100%, 1.0)'),
                ],
                [
                    HSLA::from('hsla(0, 0%, 0%, 0.0)'),
                    HSLA::from('hsla(360, 100%, 100%, 1.0)'),
                    3
                ],
            ],
            [
                [
                    HSLA::from('hsla(0, 100%, 50%, 1.0)'),
                    HSLA::from('hsla(180, 100%, 50%, 1.0)'),
                    HSLA::from('hsla(360, 100%, 50%, 1.0)'),
                ],
                [
                    HSLA::from('hsla(0, 100%, 50%)'),
                    HSLA::from('hsla(360, 100%, 50%)'),
                    3
                ],
            ],
            [
                [
                    HSLA::from('hsla(0, 100%, 50%, 1.0)'),
                    HSLA::from('hsla(120, 100%, 50%, 1.0)'),
                    HSLA::from('hsla(240, 100%, 50%, 1.0)'),
                    HSLA::from('hsla(360, 100%, 50%, 1.0)'),
                ],
                [
                    HSLA::from('hsla(0, 100%, 50%)'),
                    HSLA::from('hsla(360, 100%, 50%)'),
                    4
                ],
            ],
            [
                [
                    HSLA::from('hsla(0, 0%, 50%, 1)'),
                    HSLA::from('hsla(5, 1%, 50%, 1)'),
                    HSLA::from('hsla(9, 3%, 50%, 1)'),
                    HSLA::from('hsla(14, 4%, 50%, 1)'),
                    HSLA::from('hsla(19, 5%, 50%, 1)'),
                    HSLA::from('hsla(24, 7%, 50%, 1)'),
                    HSLA::from('hsla(28, 8%, 50%, 1)'),
                    HSLA::from('hsla(33, 9%, 50%, 1)'),
                    HSLA::from('hsla(38, 11%, 50%, 1)'),
                    HSLA::from('hsla(43, 12%, 50%, 1)'),
                    HSLA::from('hsla(47, 13%, 50%, 1)'),
                    HSLA::from('hsla(52, 14%, 50%, 1)'),
                    HSLA::from('hsla(57, 16%, 50%, 1)'),
                    HSLA::from('hsla(62, 17%, 50%, 1)'),
                    HSLA::from('hsla(66, 18%, 50%, 1)'),
                    HSLA::from('hsla(71, 20%, 50%, 1)'),
                    HSLA::from('hsla(76, 21%, 50%, 1)'),
                    HSLA::from('hsla(81, 22%, 50%, 1)'),
                    HSLA::from('hsla(85, 24%, 50%, 1)'),
                    HSLA::from('hsla(90, 25%, 50%, 1)'),
                    HSLA::from('hsla(95, 26%, 50%, 1)'),
                    HSLA::from('hsla(99, 28%, 50%, 1)'),
                    HSLA::from('hsla(104, 29%, 50%, 1)'),
                    HSLA::from('hsla(109, 30%, 50%, 1)'),
                    HSLA::from('hsla(114, 32%, 50%, 1)'),
                    HSLA::from('hsla(118, 33%, 50%, 1)'),
                    HSLA::from('hsla(123, 34%, 50%, 1)'),
                    HSLA::from('hsla(128, 36%, 50%, 1)'),
                    HSLA::from('hsla(133, 37%, 50%, 1)'),
                    HSLA::from('hsla(137, 38%, 50%, 1)'),
                    HSLA::from('hsla(142, 39%, 50%, 1)'),
                    HSLA::from('hsla(147, 41%, 50%, 1)'),
                    HSLA::from('hsla(152, 42%, 50%, 1)'),
                    HSLA::from('hsla(156, 43%, 50%, 1)'),
                    HSLA::from('hsla(161, 45%, 50%, 1)'),
                    HSLA::from('hsla(166, 46%, 50%, 1)'),
                    HSLA::from('hsla(171, 47%, 50%, 1)'),
                    HSLA::from('hsla(175, 49%, 50%, 1)'),
                    HSLA::from('hsla(180, 50%, 50%, 1)'),
                    HSLA::from('hsla(185, 51%, 50%, 1)'),
                    HSLA::from('hsla(189, 53%, 50%, 1)'),
                    HSLA::from('hsla(194, 54%, 50%, 1)'),
                    HSLA::from('hsla(199, 55%, 50%, 1)'),
                    HSLA::from('hsla(204, 57%, 50%, 1)'),
                    HSLA::from('hsla(208, 58%, 50%, 1)'),
                    HSLA::from('hsla(213, 59%, 50%, 1)'),
                    HSLA::from('hsla(218, 61%, 50%, 1)'),
                    HSLA::from('hsla(223, 62%, 50%, 1)'),
                    HSLA::from('hsla(227, 63%, 50%, 1)'),
                    HSLA::from('hsla(232, 64%, 50%, 1)'),
                    HSLA::from('hsla(237, 66%, 50%, 1)'),
                    HSLA::from('hsla(242, 67%, 50%, 1)'),
                    HSLA::from('hsla(246, 68%, 50%, 1)'),
                    HSLA::from('hsla(251, 70%, 50%, 1)'),
                    HSLA::from('hsla(256, 71%, 50%, 1)'),
                    HSLA::from('hsla(261, 72%, 50%, 1)'),
                    HSLA::from('hsla(265, 74%, 50%, 1)'),
                    HSLA::from('hsla(270, 75%, 50%, 1)'),
                    HSLA::from('hsla(275, 76%, 50%, 1)'),
                    HSLA::from('hsla(279, 78%, 50%, 1)'),
                    HSLA::from('hsla(284, 79%, 50%, 1)'),
                    HSLA::from('hsla(289, 80%, 50%, 1)'),
                    HSLA::from('hsla(294, 82%, 50%, 1)'),
                    HSLA::from('hsla(298, 83%, 50%, 1)'),
                    HSLA::from('hsla(303, 84%, 50%, 1)'),
                    HSLA::from('hsla(308, 86%, 50%, 1)'),
                    HSLA::from('hsla(313, 87%, 50%, 1)'),
                    HSLA::from('hsla(317, 88%, 50%, 1)'),
                    HSLA::from('hsla(322, 89%, 50%, 1)'),
                    HSLA::from('hsla(327, 91%, 50%, 1)'),
                    HSLA::from('hsla(332, 92%, 50%, 1)'),
                    HSLA::from('hsla(336, 93%, 50%, 1)'),
                    HSLA::from('hsla(341, 95%, 50%, 1)'),
                    HSLA::from('hsla(346, 96%, 50%, 1)'),
                    HSLA::from('hsla(351, 97%, 50%, 1)'),
                    HSLA::from('hsla(355, 99%, 50%, 1)'),
                    HSLA::from('hsla(360, 100%, 50%, 1)'),
                ],
                [
                    HSLA::from('hsla(0, 0%, 50%)'),
                    HSLA::from('hsla(360, 100%, 50%)'),
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
                    self::RESULT => HSLA::from('hsla(0, 0%, 100%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [1, '#000', '#fff', 2],
                ],
            ],
            [
                [
                    self::RESULT => HSLA::from('hsla(0, 0%, 0%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [0, '#000', '#fff', 2],
                ],
            ],
            [
                [
                    self::RESULT => HSLA::from('hsla(0, 0%, 0%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [-10, '#000', '#fff', 2],
                ],
            ],
            [
                [
                    self::RESULT => HSLA::from('hsla(0, 0%, 0%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [0, '#000', '#fff', 2],
                ],
            ],
            [
                [
                    self::RESULT => HSLA::from('hsla(0, 0%, 100%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [99, '#000', '#fff', 100],
                ],
            ],
            [
                [
                    self::RESULT => HSLA::from('hsla(0, 0%, 33%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [33, '#000', '#fff', 100],
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
                    self::RESULT => HSLA::from('hsla(0, 0%, 100%, 1.0)'),
                ],
                [
                    self::ARGUMENTS => [15, '#000000', '#ffffff', 12],
                ],
            ],
            [
                [
                    self::RESULT => HSLA::from('hsla(0, 0%, 0%, 1.0)'),
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
    ): IGradient {
        return new HSLAGradient(
            range: $range ?? $this->getColorRange(),
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
        );

        $result = iterator_to_array($gradient->unwrap($count));

        self::assertEquals($expected, $result);
        self::assertCount($count, $result);
    }

    #[Test]
    public function throwsIfGetOneCountLessThenTwo(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Number of colors must be greater than 2.');

        $gradient = $this->getTesteeInstance();

        $gradient->getOne(1, 1);

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

        $count = array_shift($args);

        $gradient = $this->getTesteeInstance(
            range: $colorRange,
        );

        $result = $gradient->getOne($index, $count);

        if ($expectedException) {
            self::fail(
                'Exception was not thrown.' . ' ' . $exceptionMessage
            );
        }

        self::assertEquals($expected[self::RESULT], $result, 'Actual result: ' . $result->toString());
    }
}
