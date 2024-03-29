<?php

declare(strict_types=1);

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\AbstractDumper;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;
use Symfony\Component\VarDumper\VarDumper;

require_once __DIR__ . '/../vendor/autoload.php';

if (class_exists(NunoMaduro\Collision\Provider::class)) {
    // // Note: interferes with event-loop autostart in case of exception
    (new NunoMaduro\Collision\Provider())->register(); // see [889ad594-ca28-4770-bb38-fd5bd8cb1777]
}

if (class_exists(Symfony\Component\VarDumper\VarDumper::class)) {
    $cloner = new VarCloner();

    $dumper =
        new ServerDumper(
            getHost(),
            getDumper(),
            [
                'cli' => new CliContextProvider(),
                'source' => new SourceContextProvider(),
            ]
        );

    VarDumper::setHandler(
        static function ($var) use ($cloner, $dumper): void {
            $dumper->dump($cloner->cloneVar($var)); // dump
        }
    );
}

function getHost(): string
{
    $srv = getenv('VAR_DUMPER_SERVER');

    return $srv === false
        ? 'tcp://127.0.0.1:9912'
        : sprintf('tcp://%s', $srv);
}

function getDumper(): AbstractDumper
{
    return in_array(PHP_SAPI, ['cli', 'phpdbg'], true)
        ? new CliDumper()
        : new HtmlDumper();
}

if (!function_exists('dump')) {
    function dump(...$vars): mixed
    {
        if (!$vars) {
            return null;
        }

        if (array_key_exists(0, $vars) && 1 === count($vars)) {
            var_dump($vars[0]);
            $k = 0;
        } else {
            foreach ($vars as $k => $v) {
                var_dump($v);
            }
        }

        if (1 < count($vars)) {
            return $vars;
        }

        return $vars[$k];
    }
}
