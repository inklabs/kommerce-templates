<?php
namespace inklabs\KommerceTemplates\Lib;

class AssetLocationService
{
    public function getAssetFilePathByTheme($theme, $section, $path)
    {
        $kommerceTemplatesPath = realpath(__DIR__ . '/../..');

        return $kommerceTemplatesPath . '/themes/' . $theme . '/' . $section . '/assets/' . $path;
    }
}
