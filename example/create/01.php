<?php

declare(strict_types=1);

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\RGBA;

require_once __DIR__ . '/../bootstrap.php';

$source = 'hsla(360, 100%, 50%, 1)';

$rgb = RGBA::from($source);
$hsla = $rgb->to(IHSLAColor::class);
$hex = $hsla->to(IHexColor::class);

dump($hex->toString());
dump($hsla->toString());
dump($rgb->toString());

dump($source . ' →  ' . $hex->to(IHSLAColor::class)->toString());
