<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Registry;


use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Registry\Registry;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class RegistryTest extends TestCase
{
    private const FROM_CONVERTERS = 'fromConverters';
    private static mixed $fromConverters = null;

    #[Test]
    public function canBeInstantiated(): void
    {
        $registry = $this->getTesteeInstance();

        self::assertInstanceOf(Registry::class, $registry);
    }

    private function getTesteeInstance(): IRegistry
    {
        return new Registry();
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::storeRegistryState();
    }

    private static function storeRegistryState(): void
    {
        self::$fromConverters = self::getPropertyValue(Registry::class, self::FROM_CONVERTERS);
    }

    protected function tearDown(): void
    {
        self::rollbackRegistryState();
        parent::tearDown();
    }

    private static function rollbackRegistryState(): void
    {
        self::setPropertyValue(Registry::class, self::FROM_CONVERTERS, self::$fromConverters);
    }


}
