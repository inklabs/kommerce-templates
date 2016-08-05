<?php
namespace inklabs\KommerceTemplates\Lib;

class AssetLocationService
{
    public function getAssetFilePathByTheme($theme, $path)
    {
        return __DIR__ . '/../../themes/' . $theme . '/assets/' . $path;
    }
}
