<?php
namespace inklabs\KommerceTemplates\Lib;

class AssetLocationService
{
    public function getAssetFilePathByTheme($theme, $path)
    {
        $basePath = __DIR__ . '/../../base-themes/' . $theme . '/assets/' . $path;
        if (file_exists($basePath)) {
            return $basePath;
        }

        return __DIR__ . '/../../themes/' . $theme . '/assets/' . $path;
    }
}
