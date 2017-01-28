<?php
use inklabs\KommerceTemplates\Lib\TwigThemeConfig;

$config = new TwigThemeConfig(
    'Foundation',
    'Deprecated Foundation theme',
    __DIR__,
    TwigThemeConfig::getBaseThemePath()
);

return $config;