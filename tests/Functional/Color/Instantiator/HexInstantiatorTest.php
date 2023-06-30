<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Color\Instantiator;

use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class HexInstantiatorTest extends TestCase
{
    public static function canInstantiateDataProvider(): iterable
    {
        yield from [
            [0xff0000,'#ff0000'],
            [0x0,'#000'],
            [0x0,'000'],
            [0x008080,'teal'],
            [0xffc0cb,'PINK'],
        ];
    }

    #[Test]
    #[DataProvider('canInstantiateDataProvider')]
    public function canInstantiate(int $expected, string $incoming): void
    {
        $instantiator = $this->getTesteeInstance();

        self::assertSame($expected, $instantiator->fromString($incoming)->getValue());
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new HexInstantiator();
    }
}
