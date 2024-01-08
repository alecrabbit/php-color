<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Model\DTO;

/**
 * Marker interface.
 *
 * Implementations should follow the convention:
 *     - final readonly class
 *     - public properties
 *     - constructor with all properties as arguments
 *     - int parameters implied to be in range 0-255
 *     - float parameters implied to be in range 0.0-1.0
 *     - alpha parameter should be optional with default value 1.0
 */
interface IColorDTO
{

}
