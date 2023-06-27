<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\A;

use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Tests\TestCase\TestCaseWithMocks;
use AlecRabbit\Tests\Unit\Color\A\Override\AConvertableColorOverride;
use PHPUnit\Framework\Attributes\Test;

class AConvertableColorUseMethodTest extends TestCaseWithMocks
{
    protected const CONVERTER = 'converter';
    protected const INSTANTIATOR = 'instantiator';

    protected static IColorConverter|null $converter = null;
    protected static IInstantiator|null $instantiator = null;

    #[Test]
    public function canSetConverterViaUseConverter(): void
    {
        $converter = $this->mockConverter();

        AConvertableColorOverride::useConverter($converter);

        self::assertSame($converter, $this->extractConverter());
    }

    protected function extractConverter(): ?IColorConverter
    {
        return self::getPropertyValue(AConvertableColorOverride::class, self::CONVERTER);
    }

    #[Test]
    public function canSetConverterViaUseInstantiator(): void
    {
        $instantiator = $this->mockInstantiator();

        AConvertableColorOverride::useInstantiator($instantiator);

        self::assertSame($instantiator, $this->extractInstantiator());
    }

    protected function extractInstantiator(): ?IInstantiator
    {
        return self::getPropertyValue(AConvertableColorOverride::class, self::INSTANTIATOR);
    }

    protected function setUp(): void
    {
        self::$converter = $this->extractConverter();
        self::$instantiator = $this->extractInstantiator();
    }

    protected function tearDown(): void
    {
        $this->resetConverter();
        $this->resetInstantiator();
    }

    protected function resetConverter(): void
    {
        self::setPropertyValue(
            AConvertableColorOverride::class,
            self::CONVERTER,
            self::$converter
        );
    }

    protected function resetInstantiator(): void
    {
        self::setPropertyValue(
            AConvertableColorOverride::class,
            self::INSTANTIATOR,
            self::$instantiator
        );
    }
}
