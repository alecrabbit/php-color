<?php

declare(strict_types=1);

use AlecRabbit\Color\Contract\IHSLAColor;
use Symfony\Component\VarDumper\Caster\ScalarStub;

require_once __DIR__ . '/../bootstrap.php';

$source = 'hsla(23, 100%, 50%, 0.5)';
$rgb = \AlecRabbit\Color\RGBA::fromString($source);

dump(new ScalarStub($rgb->toString()));
dump(new ScalarStub($source . ' -> ' . $rgb->to(IHSLAColor::class)->toString()));
