<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Parser;

use AlecRabbit\Color\Contract\Parser\IDHSLParser;
use AlecRabbit\Color\Contract\Parser\IParser;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Parser\HSLAParser;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HSLAParserTest extends TestCase
{
    public static function canParseDataProvider(): iterable
    {
        foreach (self::canParseDataFeeder() as $item) {
            yield [
                [self::RESULT => $item[0],],
                $item[1],
            ];
        }
        yield from [
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Invalid color format: "rgba(0 0% 0% / 0.5)".',
                    ],
                ],
                'rgba(0 0% 0% / 0.5)',
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Invalid color format: "#fff".',
                    ],
                ],
                '#fff',
            ],
        ];
    }

    private static function canParseDataFeeder(): iterable
    {
        yield from [
            [new DHSL(0, 0, 0), 'hsl(0 0% 0%)'],
            [new DHSL(0.416667, 0.3, 0.6, 0.8), 'hsl(150 30% 60% / 80%)'],
            [new DHSL(0.416667, 0.3, 0.6, 0.8), 'hsla(150 30% 60% / 80%)'],
            [new DHSL(0.556944, 0.3, 0.6, 0.8), 'hsla(200.5, 30%, 60%, 80%)'],
            [new DHSL(0.416667, 0.305, 0.6, 0.8), 'hsla(150 30.5% 60% / 80%)'],
            [new DHSL(0.416667, 0.3, 0.6, 0.78), 'hsla(150 30% 60% / 0.78)'],
            [new DHSL(0.416667, 0.3, 0.6, 0.6778), 'hsla(150 30% 60% / 67.78%)'],
            [new DHSL(1, 1, 1, 1), 'hsla(360 100% 100% / 100%)'],
            [new DHSL(1, 1, 1, 1), 'hsla(360, 100%, 100%, 1.0)'],
            [new DHSL(1, 1, 1, 1), 'hsla(360, 100%,100%, 1.0)'],
            [new DHSL(1, 1, 1, 1), 'hsla(360,100%,100%,100%)'],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $parser = $this->getTesteeInstance();

        self::assertInstanceOf(IDHSLParser::class, $parser);
        self::assertInstanceOf(HSLAParser::class, $parser);
    }

    protected function getTesteeInstance(): IParser
    {
        return new HSLAParser();
    }

    #[Test]
    #[DataProvider('canParseDataProvider')]
    public function canParse(array $expected, string $input): void
    {
        $expectedException = $this->expectsException($expected);
        $exceptionMessage =
            $expectedException === null ?: $expectedException->getMessage();

        if ($expectedException) {
            $this->expectException($expectedException::class);
            $this->expectExceptionMessage($exceptionMessage);
        }

        $parser = $this->getTesteeInstance();

        $color = $parser->parse($input);

        if ($expectedException) {
            self::fail(
                'Exception was not thrown.' . ' ' . $exceptionMessage
            );
        }

        self::assertTrue($parser->isSupported($input));

        $expectedResult = $expected[self::RESULT];
        self::assertEquals($expectedResult, $color);
    }
}
