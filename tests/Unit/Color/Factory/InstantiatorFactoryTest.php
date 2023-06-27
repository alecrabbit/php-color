<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Factory;

use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\InstantiatorFactory;
use AlecRabbit\Color\Instantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\Factory\Override\InstantiatorOverride;
use PHPUnit\Framework\Attributes\Test;

class InstantiatorFactoryTest extends TestCase
{
    #[Test]
    public function canAcceptInstantiatorClass(): void
    {
        $class = InstantiatorOverride::class;

        InstantiatorFactory::setClass($class);

        self::assertSame($class, self::getPropertyValue(InstantiatorFactory::class, 'class'));
    }

    #[Test]
    public function canCreate(): void
    {
        $instantiator = InstantiatorFactory::create();

        self::assertInstanceOf(Instantiator::class, $instantiator);
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

        InstantiatorFactory::setClass($class);

        self::fail('Exception was not thrown.');
    }
    protected function tearDown(): void
    {
        InstantiatorFactory::setClass(Instantiator::class);
    }
}
