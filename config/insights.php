<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenDefineFunctions;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenFinalClasses;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenTraits;
use NunoMaduro\PhpInsights\Domain\Metrics\Architecture\Classes;

return [
    'preset' => 'laravel',
    'ide' => 'vscode',
    'exclude' => [
        'app/Providers',
        'database/migrations',
        'storage',
    ],
    'add' => [
        Classes::class => [
            ForbiddenFinalClasses::class,
        ],
    ],
    'remove' => [
        ForbiddenTraits::class,
        ForbiddenNormalClasses::class,
        ForbiddenDefineFunctions::class,
        \NunoMaduro\PhpInsights\Domain\Insights\SyntaxCheck::class,
        \NunoMaduro\PhpInsights\Domain\Insights\ForbiddenPublicProperties::class,
    ],
    'config' => [
    ],
];