<?php
use inklabs\KommerceTemplates\Lib\TwigThemeConfig;

$config = new TwigThemeConfig(
    'Foundation',
    'Deprecated Foundation theme',
    __DIR__,
    TwigThemeConfig::getBaseThemePath()
);

$config->addScssImportPath(
    realpath(__DIR__ . '/../../../../../vendor') . '/zurb/foundation/scss'
);

return $config;