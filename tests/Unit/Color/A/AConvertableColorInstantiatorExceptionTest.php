<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\A;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Contract\IColorInstantiator;
use AlecRabbit\Color\Exception\ColorException;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\A\Override\AConvertableColorOverride;
use PHPUnit\Framework\Attributes\Test;

class AConvertableColorInstantiatorExceptionTest extends TestCase
{
    protected const INSTANTIATOR = 'instantiator';
    protected static IColorInstantiator|null $instantiator = null;

    #[Test]
    public function throwsColorExceptionIfInstantiatorIsNotSet(): void
    {
        $this->wrapExceptionTest(
            function () {
                AConvertableColor::fromString('red');
            },
            new ColorException('Instantiator is not set.')
        );
    }

    protected function setUp(): void
    {
        self::$instantiator = self::getPropertyValue(AConvertableColorOverride::class, self::INSTANTIATOR);
        self::setPropertyValue(AConvertableColorOverride::class, self::INSTANTIATOR, null);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(AConvertableColorOverride::class, self::INSTANTIATOR, self::$instantiator);
    }
}
