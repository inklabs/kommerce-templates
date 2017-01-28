<?php
use inklabs\KommerceTemplates\Lib\TwigThemeConfig;

$config = new TwigThemeConfig(
    'Store Bootstrap',
    'Deprecated Bootstrap Store theme',
    __DIR__
);

$config->addScssImportPath(
    realpath(__DIR__ . '/../../../../../../vendor') . '/twbs/bootstrap-sass/assets/stylesheets'
);

return $config;
