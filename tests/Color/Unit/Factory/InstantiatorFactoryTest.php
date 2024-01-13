<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Factory;

use AlecRabbit\Color\Contract\Factory\IInstantiatorFactory;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\InstantiatorFactory;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Color\Instantiator\HSLInstantiator;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class InstantiatorFactoryTest extends TestCase
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
        $factory = $this->getTestee();
        $instantiator = $factory->getByString($color);

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($class, $instantiator);
    }

    protected function getTestee(): IInstantiatorFactory
    {
        return new InstantiatorFactory();
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

        InstantiatorFactory::register($class);

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

        $this->getTestee()->getByString($color);

        self::fail('Exception was not thrown.');
    }
}
