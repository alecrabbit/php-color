<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;

abstract readonly class ACoreConverter implements ICoreConverter
{
    protected const FLOAT_PRECISION = 2;
    /** @var class-string<IColorDTO> */
    protected string $inputType;

    public function __construct(
        string $type = null,
        protected int $precision = self::FLOAT_PRECISION,
    ) {
        /** @var null|class-string<IColorDTO> $type */
        $this->inputType = $type ?? static::inputType();
    }

    /**
     * @return class-string<IColorDTO>
     */
    abstract protected static function inputType(): string;

    protected function assertColor(IColorDTO $color): void
    {
        if (is_a($color, $this->inputType, true)) {
            return;
        }

        throw new InvalidArgument(
            sprintf(
                'Color must be instance of "%s", "%s" given.',
                $this->inputType,
                $color::class,
            ),
        );
    }
}
