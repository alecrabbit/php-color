<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Factory;

use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\InstantiatorFactory;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Color\Instantiator\HSLInstantiator;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

class InstantiatorFactoryTest extends TestCase
{
    public static function canProvideInstantiatorDataProvider(): iterable
    {
        yield from [
            [RGBInstantiator::class, 'rgb(0, 0, 0)'],
            [HexInstantiator::class, '000'],
            [HSLInstantiator::class, 'hsl(0, 0%, 0%)'],
        ];
    }

    public static function throwsIfProvidedColorStringIsInvalidDataProvider(): iterable
    {
        yield from [
            [''],
            ['blabla'],
        ];
    }

    #[Test]
    #[DataProvider('canProvideInstantiatorDataProvider')]
    public function canProvideInstantiator(string $class, string $color): void
    {
        $instantiator = InstantiatorFactory::getInstantiator($color);

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($class, $instantiator);
    }

    #[Test]
    public function throwsIfInstantiatorClassProvidedIsInvalid(): void
    {
        $class = stdClass::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" must implement "%s" interface.',
                $class,
                IInstantiator::class,
            )
        );

        InstantiatorFactory::registerInstantiator($class);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    #[DataProvider('throwsIfProvidedColorStringIsInvalidDataProvider')]
    public function throwsIfProvidedColorStringIsInvalid(string $color): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
                'Instantiator for color "%s" is not registered.',
                $color,
            )
        );

        InstantiatorFactory::getInstantiator($color);

        self::fail('Exception was not thrown.');
    }
}
