<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Store\InstantiatorStore;

use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\Store\InstantiatorStore;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class InstantiatorStoreRegisterInstantiatorsTest extends TestCase
{
    private array $registeredInstantiators;

    #[Test]
    public function instantiatorsCanBeRegistered(): void
    {
        self::assertEmpty($this->getRegisteredInstantiators());

        InstantiatorStore::register(RGBInstantiator::class);

        self::assertContains(RGBInstantiator::class, $this->getRegisteredInstantiators());
    }

    protected function getRegisteredInstantiators(): array
    {
        return self::getPropertyValue(InstantiatorStore::class, 'registered');
    }

    protected function setRegisteredInstantiators(array $registeredInstantiators): void
    {
        self::setPropertyValue(InstantiatorStore::class, 'registered', $registeredInstantiators);
    }

    #[Test]
    public function throwsIfTargetClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);

        InstantiatorStore::register(stdClass::class, RGBInstantiator::class);
    }

    #[Test]
    public function throwsIfInstantiatorClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);

        InstantiatorStore::register(RGB::class, stdClass::class);
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
