<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Util;

use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Util\Instantiator;
use AlecRabbit\Tests\Color\Unit\Util\Override\InstantiatorStoreOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class InstantiatorSetFactoryClassMethodTest extends TestCase
{
    private const STORE_CLASS = 'storeClass';
    private string $storeClass;

    #[Test]
    public function canSetFactoryClass(): void
    {
        $class = InstantiatorStoreOverride::class;

        Instantiator::setStoreClass($class);

        self::assertSame($class, self::getPropertyValue(Instantiator::class, self::STORE_CLASS));
    }

    #[Test]
    public function throwsIfClassIsNotSubclass(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "stdClass" is not a "AlecRabbit\Color\Contract\Store\IInstantiatorStore" subclass.'
        );
        Instantiator::setStoreClass(stdClass::class);
    }

    protected function setUp(): void
    {
        $this->storeClass = self::getPropertyValue(Instantiator::class, self::STORE_CLASS);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(Instantiator::class, self::STORE_CLASS, $this->storeClass);
    }
}
