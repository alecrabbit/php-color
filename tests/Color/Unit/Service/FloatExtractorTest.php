<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Service;

use AlecRabbit\Color\Contract\Service\IFloatExtractor;
use AlecRabbit\Color\Service\FloatExtractor;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class FloatExtractorTest extends TestCase
{
    public static function canNormalizeDataProvider(): iterable
    {
        yield from [
            [1.0, '1.0', null],
            [1.0, '100.0%', null],
            [1.0, '100%', null],
            [0.11, '11%', null],
            [0.021, '2.1%', null],
            [1.0, '255', 255],
            [1.0, '360', 360],
            [0.5, '180', 360],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $extractor = $this->getTesteeInstance();

        self::assertInstanceOf(FloatExtractor::class, $extractor);
    }

    protected function getTesteeInstance(): IFloatExtractor
    {
        return new FloatExtractor();
    }

    #[Test]
    #[DataProvider('canNormalizeDataProvider')]
    public function canNormalize(float $expected, string $input, ?float $div = null): void
    {
        $extractor = $this->getTesteeInstance();

        self::assertSame($expected, $extractor->value($input, $div ?? 1.0));
    }
}
