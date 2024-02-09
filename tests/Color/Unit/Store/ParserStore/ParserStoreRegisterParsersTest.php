<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Store\ParserStore;

use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Parser\RGBAParser;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\Store\ParserStore;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ParserStoreRegisterParsersTest extends TestCase
{
    private array $registeredParsers;

    #[Test]
    public function parsersCanBeRegistered(): void
    {
        self::assertEmpty($this->getRegisteredParsers());

        ParserStore::register(RGBAParser::class);

        self::assertContains(RGBAParser::class, $this->getRegisteredParsers());
    }

    protected function getRegisteredParsers(): array
    {
        return self::getPropertyValue(ParserStore::class, 'registered');
    }

    protected function setRegisteredParsers(array $registeredParsers): void
    {
        self::setPropertyValue(ParserStore::class, 'registered', $registeredParsers);
    }

    #[Test]
    public function throwsIfTargetClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);

        ParserStore::register(stdClass::class, RGBAParser::class);
    }

    #[Test]
    public function throwsIfParserClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);

        ParserStore::register(RGB::class, stdClass::class);
    }

    protected function setUp(): void
    {
        $this->registeredParsers = $this->getRegisteredParsers();
        $this->setRegisteredParsers([]);
    }

    protected function tearDown(): void
    {
        $this->setRegisteredParsers($this->registeredParsers);
    }

}
