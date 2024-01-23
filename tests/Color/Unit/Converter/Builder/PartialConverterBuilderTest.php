<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\Builder;

use AlecRabbit\Color\Contract\Converter\Builder\IPartialConverterBuilder;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Converter\Builder\PartialConverterBuilder;
use AlecRabbit\Color\Converter\To\PartialConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Tests\TestCase\TestCase;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class PartialConverterBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(PartialConverterBuilder::class, $builder);
    }

    private function getTesteeInstance(
        ?IRegistry $registry = null,
    ): IPartialConverterBuilder {
        return new PartialConverterBuilder(
            registry: $registry ?? $this->getRegistryMock(),
        );
    }

    private function getRegistryMock(): MockObject&IRegistry
    {
        return $this->createMock(IRegistry::class);
    }

    #[Test]
    public function canBuild(): void
    {
        $colorModel = $this->getColorModelMock();
        $registry = $this->getRegistryMock();

        $builder = $this->getTesteeInstance(
            registry: $registry
        );

        $converter = $builder
            ->withColorModel($colorModel)
            ->build();

        self::assertInstanceOf(PartialConverter::class, $converter);
    }

    private function getColorModelMock(): MockObject&IColorModel
    {
        return $this->createMock(IColorModel::class);
    }

    #[Test]
    public function canBuildWithRegistry(): void
    {
        $colorModel = $this->getColorModelMock();
        $registry = $this->getRegistryMock();

        $builder = $this->getTesteeInstance();

        $converter = $builder
            ->withColorModel($colorModel)
            ->withRegistry($registry)
            ->build();

        self::assertInstanceOf(PartialConverter::class, $converter);
    }

    #[Test]
    public function throwsIfColorModelIsNotSet(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Target color model is not set.');

        $this->getTesteeInstance()->build();
    }
}
