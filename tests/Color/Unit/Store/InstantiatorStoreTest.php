<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Store;

use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Color\Instantiator\HSLInstantiator;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\Store\InstantiatorStore;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class InstantiatorStoreTest extends TestCase
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
        $instantiator = $factory->getByValue($color);

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($class, $instantiator);
    }

    protected function getTestee(): IInstantiatorStore
    {
        return new InstantiatorStore();
    }

    #[Test]
    public function throwsIfInstantiatorClassProvidedIsInvalid(): void
    {
        $class = stdClass::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
                'Instantiator class "%s" must implement "%s" interface.',
                $class,
                IInstantiator::class,
            )
        );

        InstantiatorStore::register(IRGBColor::class, $class);

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

        $this->getTestee()->getByValue($color);

        self::fail('Exception was not thrown.');
    }
}
