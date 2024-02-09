<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Service;

use AlecRabbit\Color\Contract\Service\IHexColorStrNormalizer;
use AlecRabbit\Color\Service\HexColorStrNormalizer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class HexColorStrNormalizerTest extends TestCase
{
    public static function canNormalizeDataProvider(): iterable
    {
        yield from [
            ['000000', '#000'],
            ['000000', '000'],
            ['223344', '234'],
            ['11223344', '1234'],
            ['11223344', '#1234'],
            ['11223344', '#11223344'],
            ['11223344', '11223344'],
            ['ffaaffaa', '#ffaaffaa'],
            ['ffaaffaa', '#fafa'],
            ['ffaaffaa', 'fafa'],
            ['aabbccdd', '#abcd'],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $normalizer = $this->getTesteeInstance();

        self::assertInstanceOf(HexColorStrNormalizer::class, $normalizer);
    }

    protected function getTesteeInstance(): IHexColorStrNormalizer
    {
        return new HexColorStrNormalizer();
    }

    #[Test]
    #[DataProvider('canNormalizeDataProvider')]
    public function canNormalize(string $expected, string $input): void
    {
        $normalizer = $this->getTesteeInstance();

        self::assertEquals($expected, $normalizer->normalize($input));
    }
}
