<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\RegExp;


use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

/**
 * This test does not test any package class.
 * It is used to test regular expression pattern.
 */
final class RegExpTest extends TestCase
{
    public static function hslaRegExpDataFeeder(): iterable
    {
        yield from        [
            [['150', '3.5%', '60%', '80%'], 'hsla(150 3.5% 60% / 80%)',],
            [['145.12', '13.5%', '22.3%', '1.0'], 'hsl(145.12, 13.5%, 22.3%)',],
            [['145.12', '13.5%', '22.3%', '0.5'], 'hsl(145.12, 13.5%, 22.3% / 0.5)',],
            [['188', '18%', '24%', '0.5',], 'hsla(188 18% 24% / 0.5)',],
            [['188', '18%', '24%', '0.5',], 'hsla(188, 18%, 24% / 0.5)',],
            [['188.0', '18%', '24%', '0.5',], 'hsl(188.0 18% 24% / 0.5)',],
            [['145.12', '13.5%', '22%', '0.5',], 'hsla(145.12 13.5% 22% / 0.5)',],
            [['145.12', '13.5%', '22.3%', '1',], 'hsla(145.12 13.5% 22.3% / 1)',],
            [['145.12', '0%', '22.3%', '12.2%',], 'hsl(145.12 0% 22.3% / 12.2%)',],
            [['145.12', '13.5%', '22.3%', '0.5',], 'hsla(145.12, 13.5%, 22.3% / 0.5)',],
            [['145.12', '13.5%', '22.3%', '100%',], 'hsla(145.12 13.5% 22.3% / 100%)',],
            [['145.12', '13.5%', '22.3%', '100%',], 'hsla(145.12, 13.5%, 22.3%, 100%)',],
        ];
    }

    public static function rgbaRegExpDataFeeder(): iterable
    {
        yield from        [
            [['150', '3.5%', '60%', '80%'], 'rgba(150 3.5% 60% / 80%)',],
            [['145.12', '13.5%', '22.3%', '1.0'], 'rgb(145.12, 13.5%, 22.3%)',],
            [['145.12', '13.5%', '22.3%', '0.5'], 'rgb(145.12, 13.5%, 22.3% / 0.5)',],
            [['32', '45', '67', '78%'], 'rgb(32 45 67 / 78%)',],
            [['188', '18%', '24%', '0.5',], 'rgba(188 18% 24% / 0.5)',],
            [['188', '18%', '24%', '0.5',], 'rgba(188, 18%, 24% / 0.5)',],
            [['188.0', '18%', '24%', '0.5',], 'rgb(188.0 18% 24% / 0.5)',],
            [['145.12', '13.5%', '22%', '0.5',], 'rgba(145.12 13.5% 22% / 0.5)',],
            [['145.12', '13.5%', '22.3%', '1',], 'rgba(145.12 13.5% 22.3% / 1)',],
            [['145.12', '0%', '22.3%', '12.2%',], 'rgb(145.12 0% 22.3% / 12.2%)',],
            [['145.12', '13.5%', '22.3%', '0.5',], 'rgba(145.12, 13.5%, 22.3% / 0.5)',],
            [['145.12', '13.5%', '22.3%', '100%',], 'rgba(145.12 13.5% 22.3% / 100%)',],
            [['145.12', '13.5%', '22.3%', '100%',], 'rgba(145.12, 13.5%, 22.3%, 100%)',],
        ];
    }

    public static function validateRegexpDataProvider(): iterable
    {
        foreach (self::hslaRegExpDataFeeder() as $item) {
            yield [
                '/^hsla?\((\d+(\.\d+)?%?)(?:,\s*|\s*)(\d+(\.\d+)?%?)(?:,\s*|\s*)(\d+(\.\d+)?%?)(?:(?:,\s*|\s*\/\s*)(\d+(\.\d+)?%?))?\)$/',
                $item[0],
                $item[1],
            ];
        }
        foreach (self::rgbaRegExpDataFeeder() as $item) {
            yield [
                '/^rgba?\((\d+(\.\d+)?%?)(?:,\s*|\s*)(\d+(\.\d+)?%?)(?:,\s*|\s*)(\d+(\.\d+)?%?)(?:(?:,\s*|\s*\/\s*)(\d+(\.\d+)?%?))?\)$/',
                $item[0],
                $item[1],
            ];
        }
    }

    #[Test]
    #[DataProvider('validateRegexpDataProvider')]
    public function validateRegexp(string $pattern ,array $expected, string $input): void
    {
        preg_match($pattern, $input, $matches);

        $result = [
            $matches[1],
            $matches[3],
            $matches[5],
            $matches[7] ?? '1.0',
        ];

        self::assertEquals($expected, $result);
    }


}
