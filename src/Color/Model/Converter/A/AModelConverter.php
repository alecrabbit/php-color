<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\A;

use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;

use function is_a;
use function sprintf;

abstract readonly class AModelConverter implements IModelConverter
{
    /** @var class-string<IColorDTO> */
    protected string $inputType;
    protected ICoreConverter $converter;

    public function __construct(string $type = null, ICoreConverter $converter = null)
    {
        /** @var null|class-string<IColorDTO> $type */
        $this->inputType = $type ?? static::from()->dtoType();
        $this->converter = $converter ?? static::createConverter();
    }

    public static function from(): IColorModel
    {
        return new (static::getFromModelClass())();
    }

    /**
     * @return class-string<IColorModel>
     */
    abstract protected static function getFromModelClass(): string;

    protected static function createConverter(): ICoreConverter
    {
        return new (static::getConverterClass())();
    }

    abstract protected static function getConverterClass(): string;

    public static function to(): IColorModel
    {
        return new (static::getToModelClass())();
    }

    /**
     * @return class-string<IColorModel>
     */
    abstract protected static function getToModelClass(): string;

    public function convert(IColorDTO $color): IColorDTO
    {
        return $this->converter->convert($color);
    }

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
