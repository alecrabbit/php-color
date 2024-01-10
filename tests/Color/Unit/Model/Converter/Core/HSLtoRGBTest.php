<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core;


use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILegacyCoreConverter;
use AlecRabbit\Color\Model\Converter\Core\HSLToRGB;
use AlecRabbit\Color\Model\Converter\Core\LegacyCoreConverter;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HSLtoRGBTest extends TestCase
{
    public static function canConvertHSLToRGBDataProvider(): iterable
    {
        yield from [
            // [expected, incoming]
            [new DRGB(0, 0, 0), new DHSL(0, 0, 0)],
            [new DRGB(0, 0, 0), new DHSL(12, 0, 0)],
            [new DRGB(191, 204, 163), new DHSL(79, 0.29, 0.72)],
            [new DRGB(74, 247, 204), new DHSL(165, 0.92, 0.63)],
            [new DRGB(140, 95, 54), new DHSL(29, 0.44, 0.38)],
            [new DRGB(82, 111, 255), new DHSL(230, 1, 0.66)],
            [new DRGB(182, 94, 67), new DHSL(14, 0.46, 0.49)],
            [new DRGB(75, 102, 149), new DHSL(218, 0.33, 0.44)],
            [new DRGB(186, 94, 69), new DHSL(13, 0.46, 0.50)],
            [new DRGB(242, 58, 7), new DHSL(13, 0.94, 0.49)],
            [new DRGB(245, 195, 189), new DHSL(7, 0.73, 0.85)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(HSLToRGB::class, $converter);
    }

    protected function getTesteeInstance(
        ?int $precision = null,
    ): ICoreConverter {
        return new HSLToRGB(
            precision: $precision ?? 2,
        );
    }

    #[Test]
    #[DataProvider('canConvertHSLToRGBDataProvider')]
    public function canConvertHSLToRGB(DRGB $expected, DHSL $incoming): void
    {
        $converter = $this->getTesteeInstance();

        self::assertEquals(
            $expected,
            $converter->convert($incoming)
        );
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
