<?php
use inklabs\KommerceTemplates\Lib\TwigThemeConfig;

$config = new TwigThemeConfig(
    'Admin Bootstrap',
    'Deprecated Bootstrap Admin theme',
    __DIR__
);

$config->addScssImportPath(
    realpath(__DIR__ . '/../../../../../../vendor') . '/twbs/bootstrap-sass/assets/stylesheets'
);

return $config;
