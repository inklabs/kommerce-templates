<?php
namespace inklabs\KommerceTemplates\Lib;

use Twig_Environment;
use Twig_Extensions_Extension_I18n;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;

class TwigTemplate
{
    /** @var Twig_Environment */
    private $twigEnvironment;

    public function __construct(
        $baseTheme,
        CSRFTokenGeneratorInterface $csrfTokenGenerator,
        RouteUrlInterface $routeUrl,
        $paths = []
    ) {
        $this->addBaseTheme($paths, $baseTheme);
        $twigLoader = new Twig_Loader_Filesystem($paths);

        $this->twigEnvironment = new Twig_Environment($twigLoader);

        $this->twigEnvironment->addExtension(
            new TwigExtension(
                $csrfTokenGenerator,
                $routeUrl
            )
        );
        $this->twigEnvironment->addExtension(new Twig_Extensions_Extension_I18n());
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

    /**
     * @param array $paths
     */
    private function addBaseTheme(array & $paths, $baseTheme)
    {
        $baseThemePath = __DIR__ . '/../../themes/' . $baseTheme . '/templates';
        $paths[] = $baseThemePath;
    }

    public function addGlobal($name, $value)
    {
        $this->twigEnvironment->addGlobal($name, $value);
    }
}
