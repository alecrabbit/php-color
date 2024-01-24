<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\Builder;

use AlecRabbit\Color\Contract\Converter\Builder\IPartialConverterBuilder;
use AlecRabbit\Color\Contract\Converter\IPartialConverter;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Converter\Builder\Dummy\AbstractBuilder;
use AlecRabbit\Color\Converter\Builder\Dummy\Dummy;
use AlecRabbit\Color\Converter\Builder\Dummy\IDummy;
use AlecRabbit\Color\Converter\To\PartialConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Registry\Registry;
use LogicException;

final class PartialConverterBuilder extends AbstractBuilder implements IPartialConverterBuilder
{
    public function __construct(
        private IDummy|IColorModel $targetColorModel = new Dummy(),
        private IRegistry $registry = new Registry(),
    ) {
    }

    /**
     * @psalm-suppress PossiblyInvalidArgument
     */
    public function build(): IPartialConverter
    {
        $this->validate();

        return new PartialConverter(
            $this->targetColorModel,
            $this->registry,
        );
    }

    protected function validate(): void
    {
        match (true) {
            $this->isDummy($this->targetColorModel) => throw new LogicException(
                'Target color model is not set.'
            ),
            default => null,
        };
    }


    public function withRegistry(IRegistry $registry): IPartialConverterBuilder
    {
        $clone = clone $this;
        $clone->registry = $registry;
        return $clone;
    }

    public function withColorModel(IColorModel $colorModel): IPartialConverterBuilder
    {
        $clone = clone $this;
        $clone->targetColorModel = $colorModel;
        return $clone;
    }
}
