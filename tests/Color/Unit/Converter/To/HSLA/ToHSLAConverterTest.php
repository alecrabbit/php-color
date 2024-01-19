<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\To\HSLA;


use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Converter\To\ToHSLAConverter;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;
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
        $dtoFrom = new DRGB(0, 0, 0);
        $dtoTo = new DHSL(0, 0, 0);
        $expected = HSLA::fromHSLA(0, 0, 0);

        $modelFrom = new ModelRGB();
        $modelTo = new ModelHSL();

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
}
