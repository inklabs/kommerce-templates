<?php
use inklabs\KommerceTemplates\Lib\TwigThemeConfig;

return new TwigThemeConfig(
    'Cardinal - Admin',
    'The default admin theme for 2016',
    __DIR__,
    TwigThemeConfig::getThemePath('bootstrap', 'admin')
);
