<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\To\HSL;


use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Converter\To\ToHSLConverter;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ToHSLConverterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $toConverter = $this->getTesteeInstance();

        self::assertInstanceOf(ToHSLConverter::class, $toConverter);
    }

    private function getTesteeInstance(
        ?IRegistry $registry = null,
    ): IToConverter {
        return new ToHSLConverter(
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
        $class = ToHSLConverter::class;
        $targets = $class::getTargets();

        self::assertCount(2, $targets);
        self::assertContains(IHSLColor::class, $targets);
        self::assertContains(HSL::class, $targets);
    }

    #[Test]
    public function canConvert(): void
    {
        $dtoFrom = new DRGB(0, 0, 0);
        $dtoTo = new DHSL(0, 0, 0);
        $expected = HSL::fromHSL(0, 0, 0);

        $modelFrom = new ModelRGB();
        $modelTo = new ModelHSL();

        $incoming = $this->getConvertableColorMock();
        $incoming
            ->expects(self::once())
            ->method('getColorModel')
            ->willReturn($modelFrom)
        ;
        $incoming
            ->expects(self::once())
            ->method('toDTO')
            ->willReturn($dtoFrom)
        ;

        $registry = $this->getConverterRegistryMock();
        $modelConverter = $this->getModelConverterMock();
        $modelConverter
            ->expects(self::once())
            ->method('convert')
            ->with($dtoFrom)
            ->willReturn($dtoTo)
        ;

        $registry
            ->expects(self::once())
            ->method('getModelConverter')
            ->with($modelFrom, $modelTo)
            ->willReturn(
                $modelConverter
            )
        ;

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
