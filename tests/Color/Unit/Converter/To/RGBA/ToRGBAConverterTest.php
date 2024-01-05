<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\To\RGBA;


use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Converter\To\RGBA\ToRGBAConverter;
use AlecRabbit\Color\RGBA;
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
        ?IRegistry $registry = null,
    ): IToConverter {
        return new ToRGBAConverter(
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
            ->with(ToRGBAConverter::class, self::stringContains('IColor'))
            ->willReturn(
                $fromConverter
            );

        $toConverter = $this->getTesteeInstance(
            registry: $registry,
        );

        $result = $toConverter->convert($incoming);

        self::assertSame($expected, $result);
    }

    private function getConvertableColorMock(): MockObject&IColor
    {
        return $this->createMock(IColor::class);
    }

    private function getFromConverterMock(): MockObject&IFromConverter
    {
        return $this->createMock(IFromConverter::class);
    }

    #[Test]
    public function canGetTargets(): void
    {
        $class = ToRGBAConverter::class;
        $targets = $class::getTargets();

        self::assertCount(2, $targets);
        self::assertContains(IRGBAColor::class, $targets);
        self::assertContains(RGBA::class, $targets);
    }
}
