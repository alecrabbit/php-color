<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter;


use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Converter\RGBToHSLModelConverter;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RGBToHSLModelConverterTest extends TestCase
{
    #[Test]
    public function returnsCorrectModelTo(): void
    {
        self::assertEquals(new ModelHSL(), RGBToHSLModelConverter::to());
    }

    #[Test]
    public function returnsCorrectModelFrom(): void
    {
        self::assertEquals(new ModelRGB(), RGBToHSLModelConverter::from());
    }

    #[Test]
    public function canConvert(): void
    {
        $input = new DRGB(0, 0, 0);
        $expected = new DHSL(0, 0, 0);

        $converter = $this->getConverterMock();
        $converter
            ->expects($this->once())
            ->method('rgbToHsl')
            ->willReturn($expected);

        $testee = $this->getTesteeInstance(
            converter: $converter,
        );

        $result = $testee->convert($input);

        self::assertSame($expected, $result);
    }

    protected function getTesteeInstance(
        ?ICoreConverter $converter = null
    ): RGBToHSLModelConverter {
        return new RGBToHSLModelConverter(
            converter: $converter ?? $this->getConverterMock(),
        );
    }

    protected function getConverterMock(): MockObject&ICoreConverter
    {
        return $this->createMock(ICoreConverter::class);
    }

    #[Test]
    public function throwsIfModelIsNotCorrect(): void
    {
        $input = new DHSL(0, 0, 0);

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Color must be instance of "AlecRabbit\Color\Model\DTO\DRGB", "AlecRabbit\Color\Model\DTO\DHSL" given.'
        );

        $testee = $this->getTesteeInstance();

        $testee->convert($input);
    }
}
