<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Color\Instantiator;

use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator\Instantiator;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ColorInstantiatorTest extends TestCase
{
    public static function canInstantiateFromStringDataProvider(): iterable
    {
        foreach (self::canInstantiateFromStringDataFeeder() as $item) {
            yield [
                $item[0],
                $item[1]
            ];
        }
    }

    private static function canInstantiateFromStringDataFeeder(): iterable
    {
        yield from [
            // (resulting)class, (incoming)value
            [Hex::class, '#ff00ff'],
            [RGBA::class, 'rgba(255, 0, 255, 1)'],
            [HSL::class, 'hsl(234, 100%, 50%)'],
            [HSLA::class, 'hsla(234, 100%, 50%, 1)'],
            [RGB::class, 'rgb(255, 0, 255)'],
        ];
    }

    #[Test]
    public function canBeCreated(): void
    {
        $testee = $this->getTestee();

        self::assertInstanceOf(Instantiator::class, $testee);
    }

    protected function getTestee(): IInstantiator
    {
        return new Instantiator();
    }

    #[Test]
    #[DataProvider('canInstantiateFromStringDataProvider')]
    public function canInstantiateFromString(string $expectedClass, string $incoming): void
    {
        $testee = $this->getTestee();

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($expectedClass, $testee->fromString($incoming));
    }
}
