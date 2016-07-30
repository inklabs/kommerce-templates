<?php
namespace inklabs\KommerceTemplates\Lib;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;

class TwigTemplate
{
    /** @var Twig_Environment */
    private $twigEnvironment;

    public function __construct($paths = [])
    {
        $this->addBaseTheme($paths);

        $twigLoader = new Twig_Loader_Filesystem($paths);
        $this->twigEnvironment = new Twig_Environment($twigLoader);
        $this->addCustomFilters();
    }

    public function enableDebug()
    {
        $this->twigEnvironment->enableDebug();
    }

    /**
     * @return Twig_Environment
     */
    public function getTwigEnvironment()
    {
        return $this->twigEnvironment;
    }

    private function addCustomFilters()
    {
        $displayPriceFilter = new Twig_SimpleFilter(
            'displayPrice',
            function ($price) {
                return '$' . number_format(($price / 100), 2);
            }
        );

        $this->twigEnvironment->addFilter($displayPriceFilter);
    }

    /**
     * @param array $paths
     */
    private function addBaseTheme(array & $paths)
    {
        $baseThemePath = __DIR__ . '/../../themes/base/templates';
        $paths[] = $baseThemePath;
    }
}
