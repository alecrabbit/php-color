<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\To\RGBA;


use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverterRegistry;
use AlecRabbit\Color\Contract\IFromConverter;
use AlecRabbit\Color\Contract\IToConverter;
use AlecRabbit\Color\Converter\To\RGBA\ToRGBAConverter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ToRGBAConverterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $toConverter = $this->getTesteeInstance();

        self::assertInstanceOf(ToRGBAConverter::class, $toConverter);
    }

    private function getTesteeInstance(
        ?IConverterRegistry $registry = null,
    ): IToConverter {
        return new ToRGBAConverter(
            registry: $registry ?? $this->getConverterRegistryMock(),
        );
    }

    private function getConverterRegistryMock(): MockObject&IConverterRegistry
    {
        return $this->createMock(IConverterRegistry::class);
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
            ->with(ToRGBAConverter::class, self::stringContains('IConvertableColor'))
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
