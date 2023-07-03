<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Factory\InstantiatorFactory;

use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\InstantiatorFactory;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\RGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

class InstantiatorFactoryRegisterInstantiatorsTest extends TestCase
{
    private array $registeredInstantiators;

    #[Test]
    public function instantiatorsCanBeRegistered(): void
    {
        self::assertEmpty($this->getRegisteredInstantiators());

        InstantiatorFactory::registerInstantiator(RGBInstantiator::class);

        self::assertContains(RGBInstantiator::class, $this->getRegisteredInstantiators());
    }

    protected function getRegisteredInstantiators(): array
    {
        return self::getPropertyValue(InstantiatorFactory::class, 'registeredInstantiators');
    }

    protected function setRegisteredInstantiators(array $registeredInstantiators): void
    {
        self::setPropertyValue(InstantiatorFactory::class, 'registeredInstantiators', $registeredInstantiators);
    }

    #[Test]
    public function throwsIfTargetClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);

        InstantiatorFactory::registerInstantiator(stdClass::class, RGBInstantiator::class);
    }

    #[Test]
    public function throwsIfInstantiatorClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);

        InstantiatorFactory::registerInstantiator(RGB::class, stdClass::class);
    }

    protected function setUp(): void
    {
        $this->registeredInstantiators = $this->getRegisteredInstantiators();
        $this->setRegisteredInstantiators([]);
    }

    protected function tearDown(): void
    {
        $this->setRegisteredInstantiators($this->registeredInstantiators);
    }

}
