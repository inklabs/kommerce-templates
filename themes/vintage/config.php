<?php
use inklabs\KommerceTemplates\Lib\TwigThemeConfig;

return new TwigThemeConfig(
    'Vintage',
    'Minimal theme extending from Cardinal',
    __DIR__,
    TwigThemeConfig::getThemePath('cardinal')
);
