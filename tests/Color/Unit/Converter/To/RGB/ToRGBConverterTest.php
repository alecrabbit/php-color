<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\To\RGB;


use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Converter\To\RGB\ToRGBConverter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ToRGBConverterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $toConverter = $this->getTesteeInstance();

        self::assertInstanceOf(ToRGBConverter::class, $toConverter);
    }

    private function getTesteeInstance(
        ?IRegistry $registry = null,
    ): IToConverter {
        return new ToRGBConverter(
            registry: $registry ?? $this->getConverterRegistryMock(),
        );
    }

    private function getConverterRegistryMock(): MockObject&IRegistry
    {
        return $this->createMock(IRegistry::class);
    }

    #[Test]
    public function canConvert(): void
    {
        $incoming = $this->getConvertableColorMock();
        $expected = $this->getConvertableColorMock();

        $registry = $this->getConverterRegistryMock();
        $fromConverter = $this->getFromConverterMock();
        $fromConverter
            ->expects(self::once())
            ->method('convert')
            ->with($incoming)
            ->willReturn($expected);

        $registry
            ->expects(self::once())
            ->method('getFromConverter')
            ->with(ToRGBConverter::class, self::stringContains('IConvertableColor'))
            ->willReturn(
                $fromConverter
            );

        $toConverter = $this->getTesteeInstance(
            registry: $registry,
        );

        $result = $toConverter->convert($incoming);

        self::assertSame($expected, $result);
    }

    private function getConvertableColorMock(): MockObject&IConvertableColor
    {
        return $this->createMock(IConvertableColor::class);
    }

    private function getFromConverterMock(): MockObject&IFromConverter
    {
        return $this->createMock(IFromConverter::class);
    }
}
