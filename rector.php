<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\ValueObject\PhpVersion;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([__DIR__ . '/src']);

    // The repo's composer.json pins config.platform.php to 7.4, which Rector
    // would otherwise treat as the upgrade ceiling. Declare the *target* version
    // so 8.x rules (promotion, str_contains, match, ...) actually apply.
    $rectorConfig->phpVersion(PhpVersion::PHP_83);

    // Upgrade idioms from PHP 7.4 up to 8.3.
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_83,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
    ]);

    // In a framework app you would also pull in the dedicated rulesets, e.g.:
    //   composer require --dev rector/rector-symfony
    //   composer require --dev driftingly/rector-laravel   (v2.5.0, the maintained Laravel ruleset)
    // and register their SetLists here. The demo app is vanilla, so they are not enabled.
};
