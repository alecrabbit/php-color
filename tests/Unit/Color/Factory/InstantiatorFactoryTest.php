<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Factory;

use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\InstantiatorFactory;
use AlecRabbit\Color\Instantiator;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\Factory\Override\InstantiatorOverride;
use PHPUnit\Framework\Attributes\Test;

class InstantiatorFactoryTest extends TestCase
{
    #[Test]
    public function canProvideInstantiator(): void
    {
        $instantiator = InstantiatorFactory::getInstantiator('rgb(0, 0, 0)');

        self::assertInstanceOf(RGBInstantiator::class, $instantiator);
    }

    #[Test]
    public function throwsIfClassProvidedIsInvalid(): void
    {
        $class = \stdClass::class;

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
}
