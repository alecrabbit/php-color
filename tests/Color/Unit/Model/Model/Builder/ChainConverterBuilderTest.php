<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Model\Builder;

use AlecRabbit\Color\Model\Builder\ChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Builder\IChainConverterBuilder;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ChainConverterBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(ChainConverterBuilder::class, $builder);
    }

    private function getTesteeInstance(): IChainConverterBuilder
    {
        return new ChainConverterBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $converter = $builder
            ->withConverters(new \ArrayObject())
            ->forPath(new \ArrayObject())
            ->build();

        self::assertInstanceOf(ChainConverterBuilder::class, $builder);
    }

    #[Test]
    public function throwsIfConvertersAreNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Converters are not set.');

        $builder
            ->forPath(new \ArrayObject())
            ->build();
    }

    #[Test]
    public function throwsIfPathIsNotProvidedSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Path is not provided.');

        $builder
            ->withConverters(new \ArrayObject())
            ->build();
    }
}
