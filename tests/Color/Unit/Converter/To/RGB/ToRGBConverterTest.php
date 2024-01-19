<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\To\RGB;


use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\To\ToRGBConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\RGB;
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
        $dtoFrom = new DHSL(0, 0, 0);
        $dtoTo = new DRGB(0, 0, 0);
        $expected = RGB::fromRGB(0, 0, 0);

        $modelFrom = new ModelHSL();
        $modelTo = new ModelRGB();

        $incoming = $this->getConvertableColorMock();
        $incoming
            ->expects(self::once())
            ->method('getColorModel')
            ->willReturn($modelFrom);

        $incoming
            ->expects(self::once())
            ->method('to')
            ->willReturn($dtoFrom);

        $registry = $this->getConverterRegistryMock();
        $modelConverter = $this->getModelConverterMock();
        $modelConverter
            ->expects(self::once())
            ->method('convert')
            ->with($dtoFrom)
            ->willReturn($dtoTo);

        $registry
            ->expects(self::once())
            ->method('getColorConverter')
            ->with($modelFrom, $modelTo)
            ->willReturn(
                $modelConverter
            );

        $toConverter = $this->getTesteeInstance(
            registry: $registry,
        );

        $result = $toConverter->convert($incoming);

        self::assertEquals($expected, $result);
    }

    private function getConvertableColorMock(): MockObject&IColor
    {
        return $this->createMock(IColor::class);
    }

    private function getModelConverterMock(): MockObject&IModelConverter
    {
        return $this->createMock(IModelConverter::class);
    }

    #[Test]
    public function canGetTargets(): void
    {
        $class = ToRGBConverter::class;
        $targets = $class::getTargets();

        self::assertCount(2, $targets);
        self::assertContains(IRGBColor::class, $targets);
        self::assertContains(RGB::class, $targets);
    }
}
