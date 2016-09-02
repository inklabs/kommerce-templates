<?php
use inklabs\KommerceTemplates\Lib\TwigThemeConfig;

$config = new TwigThemeConfig(
    'Bootstrap',
    'Deprecated Bootstrap theme',
    __DIR__,
    TwigThemeConfig::getBaseThemePath()
);

$config->addScssImportPath(
    realpath(__DIR__ . '/../../../../../vendor') . '/twbs/bootstrap-sass/assets/stylesheets'
);

return $config;
