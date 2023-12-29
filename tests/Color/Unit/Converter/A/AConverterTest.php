<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\A;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Tests\Color\Unit\Converter\A\Override\AConvertableColorOverride;
use AlecRabbit\Tests\Color\Unit\Converter\A\Override\AConverterOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AConverterTest extends TestCase
{
    protected const CONVERTER_TARGET_CLASS = '---dummy---';
    protected const CONVERTER_CLASS = AConverterOverride::class;

    #[Test]
    public function canBeCreated(): void
    {
        $testee = self::getTestee();

        self::assertInstanceOf(self::CONVERTER_CLASS, $testee);
    }

    private static function getTestee(): IToConverter
    {
        return new AConverterOverride();
    }

    #[Test]
    public function throwsOnUnsupportedColor(): void
    {
        $testee = self::getTestee();

        $color = new AConvertableColorOverride();

        $this->expectException(UnsupportedColorConversion::class);
        $this->expectExceptionMessage(
            'Conversion from "' .
            AConvertableColorOverride::class .
            '" to "' .
            self::CONVERTER_TARGET_CLASS
            . '" is not supported by "' .
            self::CONVERTER_CLASS
            . '".'
        );

        $testee->convert($color);
    }

}
