<?php

declare(strict_types=1);

function checkSystem(): void
{
    if (PHP_INT_SIZE === 4) {
        echo 'This library is for 64-bit systems only!' . PHP_EOL;
        exit(1);
    }
}

checkSystem();
