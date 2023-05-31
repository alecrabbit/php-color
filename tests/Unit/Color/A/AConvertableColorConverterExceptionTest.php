<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\A;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IColorInstantiator;
use AlecRabbit\Color\Exception\ColorException;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\A\Override\AConvertableColorOverride;
use PHPUnit\Framework\Attributes\Test;

class AConvertableColorConverterExceptionTest extends TestCase
{
    protected const CONVERTER = 'converter';
    protected static IColorConverter|null $converter = null;

    protected function setUp(): void
    {
        self::$converter = self::getPropertyValue(AConvertableColorOverride::class, self::CONVERTER);
        self::setPropertyValue(AConvertableColorOverride::class, self::CONVERTER, null);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(AConvertableColorOverride::class, self::CONVERTER, self::$converter);
    }

    #[Test]
    public function throwsColorExceptionIfConverterIsNotSet(): void
    {
        $this->wrapExceptionTest(
            function () {
                (new AConvertableColorOverride())->getConverterProperty();
            },
            ColorException::class,
            'Converter is not set.'
        );
    }
}
