<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Util\Color;

use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Tests\Color\Unit\Store\Override\InstantiatorStoreOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ColorSetInstantiatorStoreClassMethodTest extends TestCase
{
    private const INSTANTIATOR_STORE_CLASS = 'instantiatorStoreClass';
    private string $instantiatorStoreClass;

    #[Test]
    public function canSetFactoryClass(): void
    {
        $class = InstantiatorStoreOverride::class;

        Color::setInstantiatorStoreClass($class);

        self::assertSame($class, self::getPropertyValue(Color::class, self::INSTANTIATOR_STORE_CLASS));
    }

    #[Test]
    public function throwsIfClassIsNotSubclass(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "stdClass" is not a "AlecRabbit\Color\Contract\Store\IInstantiatorStore" subclass.'
        );
        Color::setInstantiatorStoreClass(stdClass::class);
    }

    protected function setUp(): void
    {
        $this->instantiatorStoreClass = self::getPropertyValue(Color::class, self::INSTANTIATOR_STORE_CLASS);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(Color::class, self::INSTANTIATOR_STORE_CLASS, $this->instantiatorStoreClass);
    }
}
