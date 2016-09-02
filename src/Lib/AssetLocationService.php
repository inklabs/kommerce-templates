<?php
namespace inklabs\KommerceTemplates\Lib;

class AssetLocationService
{
    public function getAssetFilePathByTheme($theme, $path)
    {
        $kommerceTemplatesPath = realpath(__DIR__ . '/../..');
        if ($theme == 'base-theme') {
            $basePath = $kommerceTemplatesPath . '/base-theme/assets/' . $path;
            if (file_exists($basePath)) {
                return $basePath;
            }
        }

        return $kommerceTemplatesPath . '/themes/' . $theme . '/assets/' . $path;
    }
}
