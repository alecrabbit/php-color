<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter;


use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILegacyCoreConverter;
use AlecRabbit\Color\Model\Converter\HSLToRGBModelConverter;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class HSLToRGBModelConverterTest extends TestCase
{
    #[Test]
    public function returnsCorrectModelTo(): void
    {
        self::assertEquals(new ModelRGB(), HSLToRGBModelConverter::to());
    }

    #[Test]
    public function returnsCorrectModelFrom(): void
    {
        self::assertEquals(new ModelHSL(), HSLToRGBModelConverter::from());
    }

//    #[Test]
//    public function canConvert(): void
//    {
//        // TODO (2024-01-09 14:19) [Alec Rabbit]: re-enable this test
//        $input = new DHSL(0, 0, 0);
//        $expected = new DRGB(0, 0, 0);
//
//        $converter = $this->getConverterMock();
//        $converter
//            ->expects($this->once())
//            ->method('hslToRgb')
//            ->willReturn($expected);
//
//        $testee = $this->getTesteeInstance(
//            converter: $converter,
//        );
//
//        $result = $testee->convert($input);
//
//        self::assertSame($expected, $result);
//    }

    protected function getTesteeInstance(    ): HSLToRGBModelConverter {
        return new HSLToRGBModelConverter(        );
    }

    protected function getConverterMock(): MockObject&ILegacyCoreConverter
    {
        return $this->createMock(ILegacyCoreConverter::class);
    }

    #[Test]
    public function throwsIfModelIsNotCorrect(): void
    {
        $input = new DRGB(0, 0, 0);

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Color must be instance of "AlecRabbit\Color\Model\DTO\DHSL", "AlecRabbit\Color\Model\DTO\DRGB" given.'
        );

        $testee = $this->getTesteeInstance();

        $testee->convert($input);
    }
}
