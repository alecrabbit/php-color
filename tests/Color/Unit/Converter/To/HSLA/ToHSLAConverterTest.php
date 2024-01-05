<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\To\HSLA;


use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Converter\To\HSLA\ToHSLAConverter;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ToHSLAConverterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $toConverter = $this->getTesteeInstance();

        self::assertInstanceOf(ToHSLAConverter::class, $toConverter);
    }

    private function getTesteeInstance(
        ?IRegistry $registry = null,
    ): IToConverter {
        return new ToHSLAConverter(
            registry: $registry ?? $this->getConverterRegistryMock(),
        );
    }

    private function getConverterRegistryMock(): MockObject&IRegistry
    {
        return $this->createMock(IRegistry::class);
    }

    #[Test]
    public function canGetTargets(): void
    {
        $class = ToHSLAConverter::class;
        $targets = $class::getTargets();

        self::assertCount(2, $targets);
        self::assertContains(IHSLAColor::class, $targets);
        self::assertContains(HSLA::class, $targets);
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
            ->with(ToHSLAConverter::class, self::stringContains('IColor'))
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
}
