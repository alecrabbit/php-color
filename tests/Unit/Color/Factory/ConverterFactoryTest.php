<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Factory;

use AlecRabbit\Color\ColorConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\ConverterFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\Factory\Override\AConvertableColorOverride;
use PHPUnit\Framework\Attributes\Test;

class ConverterFactoryTest extends TestCase
{
    #[Test]
    public function throwsIfConverterIsUnavailable(): void
    {
        $class = AConvertableColorOverride::class;

        $this->expectException(ConverterUnavailable::class);
        $this->expectExceptionMessage(
            sprintf(
                'Converter for "%s" is not available.',
                $class
            )
        );
        ConverterFactory::make($class);
    }

    #[Test]
    public function throwsIfClassIsNotColorSubclass(): void
    {
        $class = ColorConverter::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
            'Class "%s" is not a "%s" subclass.',
            $class,
                IConvertableColor::class
        ));
        ConverterFactory::make($class);
    }

}
