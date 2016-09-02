<?php
use inklabs\KommerceTemplates\Lib\TwigThemeConfig;

return new TwigThemeConfig(
    'Cardinal',
    'The default theme for 2016',
    __DIR__,
    TwigThemeConfig::getThemePath('bootstrap')
);
