<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Util;

use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Util\Instantiator;
use AlecRabbit\Tests\Color\Unit\Util\Override\InstantiatorFactoryOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class InstantiatorSetFactoryClassMethodTest extends TestCase
{
    private string $factoryClass;

    #[Test]
    public function canSetFactoryClass(): void
    {
        $class = InstantiatorFactoryOverride::class;

        Instantiator::setFactoryClass($class);

        self::assertSame($class, self::getPropertyValue(Instantiator::class, 'factoryClass'));
    }

    #[Test]
    public function throwsIfClassIsNotSubclass(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "stdClass" is not a "AlecRabbit\Color\Contract\Factory\IInstantiatorFactory" subclass.'
        );
        Instantiator::setFactoryClass(stdClass::class);
    }

    protected function setUp(): void
    {
        $this->factoryClass = self::getPropertyValue(Instantiator::class, 'factoryClass');
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(Instantiator::class, 'factoryClass', $this->factoryClass);
    }
}
