<?php
namespace inklabs\KommerceTemplates\Lib;

class TwigThemeConfig
{
    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $themePath;

    /** @var TwigThemeConfig | null */
    private $parentTheme;

    /** @var string[] */
    private $scssImportPaths;

    /** @var string[] */
    private $twigTemplatePaths;

    /**
     * TwigThemeConfig constructor.
     * @param string $name
     * @param string $description
     * @param string $themePath
     * @param string | null $parentThemePath
     * @throws NotFoundException
     */
    public function __construct($name, $description, $themePath, $parentThemePath = null)
    {
        if (! file_exists($themePath)) {
            throw NotFoundException::themePathNotFound();
        }

        $this->name = (string) $name;
        $this->description = (string) $description;
        $this->themePath = (string) $themePath;

        $this->addScssImportPath($themePath . '/scss');
        $this->addTwigTemplatePath($themePath . '/templates');

        if ($parentThemePath !== null) {
            $this->parentTheme = self::loadConfig($parentThemePath);
        }
    }

    public static function getBaseThemePath()
    {
        return realpath(__DIR__ . '/../..') . '/base-theme';
    }

    public static function getThemePath($theme)
    {
        return realpath(__DIR__ . '/../..') . '/themes/' . $theme;
    }

    /**
     * @param $themePath
     * @return TwigThemeConfig
     */
    public static function loadConfig($themePath)
    {
        return include($themePath . '/config.php');
    }

    /**
     * @param string $scssImportPath
     * @throws NotFoundException
     */
    public function addScssImportPath($scssImportPath)
    {
        if (! file_exists($scssImportPath)) {
            throw NotFoundException::scssPathNotFound();
        }

        $this->scssImportPaths[] = (string) $scssImportPath;
    }

    private function addTwigTemplatePath($twigTemplatePath)
    {
        if (! file_exists($twigTemplatePath)) {
            throw NotFoundException::twigTemplatePathNotFound();
        }

        $this->twigTemplatePaths[] = (string) $twigTemplatePath;
    }

    /**
     * @return string[]
     */
    public function getScssImportPaths()
    {
        $importPaths = $this->scssImportPaths;

        if ($this->hasParentTheme()) {
            $importPaths = array_merge($importPaths, $this->parentTheme->getScssImportPaths());
        }

        return $importPaths;
    }

    public function getTwigTemplatePaths()
    {
        $twigTemplatePaths = $this->twigTemplatePaths;

        if ($this->hasParentTheme()) {
            $twigTemplatePaths = array_merge($twigTemplatePaths, $this->parentTheme->getTwigTemplatePaths());
        }

        return $twigTemplatePaths;
    }

    /**
     * @return bool
     */
    private function hasParentTheme()
    {
        return $this->parentTheme !== null;
    }
}
