<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Gradient;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\Gradient\IGradients;
use AlecRabbit\Color\Gradient\Gradients;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\FactoryAwareTestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class GradientsTest extends FactoryAwareTestCase
{
    public static function canProduceGradientsDataProvider(): iterable
    {
        yield from [
            [
                [
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(255, 255, 255),
                ],
                [new ArrayObject(['#000', '#fff']),],
            ],
            [
                [
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(128, 128, 128),
                    RGBA::fromRGBO(255, 255, 255),
                ],
                [new ArrayObject(['#000', '#fff'],), 3,],
            ],
            [
                [
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(128, 128, 128),
                    RGBA::fromRGBO(255, 255, 255),
                ],
                [new ArrayObject(['#000', '#fff'],), 3, '#000'],
            ],
            [
                [
                    RGBA::fromRGBO(255, 255, 255),
                    RGBA::fromRGBO(128, 128, 128),
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(0, 0, 0),
                    RGBA::fromRGBO(128, 128, 128),
                    RGBA::fromRGBO(255, 255, 255),
                ],
                [new ArrayObject(['#000', '#fff'],), 3, '#fff'],
            ],
            [
                [
                    RGBA::fromRGBO(255, 255, 255, 1.000000),
                    RGBA::fromRGBO(170, 170, 170, 1.000000),
                    RGBA::fromRGBO(85, 85, 85, 1.000000),
                    RGBA::fromRGBO(0, 0, 0, 1.000000),
                    RGBA::fromRGBO(0, 0, 0, 1.000000),
                    RGBA::fromRGBO(85, 85, 85, 1.000000),
                    RGBA::fromRGBO(170, 170, 170, 1.000000),
                    RGBA::fromRGBO(255, 255, 255, 1.000000),

                ],
                [new ArrayObject(['#000', '#fff'],), 4, '#fff'],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $gradient = $this->getTesteeInstance();

        self::assertInstanceOf(Gradients::class, $gradient);
    }

    private function getTesteeInstance(): IGradients
    {
        return new Gradients();
    }

    #[Test]
    #[DataProvider('canProduceGradientsDataProvider')]
    public function canGenerateGradientsFromColors(array $expected, array $incoming): void
    {
        $gradients = $this->getTesteeInstance();

        $result = [];

        foreach ($gradients->create(...$incoming) as $item) {
            $result[] = $item;
        }

        self::assertEquals($expected, $result);
    }

    private function getGradientMock(): MockObject&IGradient
    {
        return $this->createMock(IGradient::class);
    }
}
