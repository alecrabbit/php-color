<?php

declare(strict_types=1);

use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\RGB;
use Symfony\Component\VarDumper\Caster\ScalarStub;

require_once __DIR__ . '/../bootstrap.php';

$rgb = RGB::fromString('hsla(0, 100%, 50%, 0.5)');

dump(new ScalarStub($rgb->to(IHSLAColor::class)->toString()));
