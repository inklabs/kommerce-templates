<?php
namespace inklabs\KommerceTemplates\Lib;

use RuntimeException;
use Twig_Environment;
use Twig_Extensions_Extension_I18n;
use Twig_Extensions_Extension_Text;
use Twig_Loader_Filesystem;

class TwigTemplate
{
    /** @var Twig_Environment */
    private $twigEnvironment;

    /**
     * @param string $baseTheme
     * @param CSRFTokenGeneratorInterface $csrfTokenGenerator
     * @param RouteUrlInterface $routeUrl
     * @param string[] $paths
     * @param string $timezone
     * @param string $dateFormat
     * @param string $timeFormat
     */
    public function __construct(
        $baseTheme,
        CSRFTokenGeneratorInterface $csrfTokenGenerator,
        RouteUrlInterface $routeUrl,
        $paths = [],
        $timezone,
        $dateFormat,
        $timeFormat
    ) {
        $this->addBaseTheme($paths, $baseTheme);
        $this->addBaseTheme($paths, 'base');
        $twigLoader = new Twig_Loader_Filesystem($paths);

        $this->twigEnvironment = new Twig_Environment($twigLoader);

        $this->twigEnvironment->addExtension(
            new TwigExtension(
                $csrfTokenGenerator,
                $routeUrl,
                $timezone,
                $dateFormat,
                $timeFormat
            )
        );
        $this->twigEnvironment->addExtension(new Twig_Extensions_Extension_I18n());
        $this->twigEnvironment->addExtension(new Twig_Extensions_Extension_Text());
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
     * @param string[] $paths
     * @param string $baseTheme
     */
    private function addBaseTheme(array & $paths, $baseTheme)
    {
        $baseThemePath = __DIR__ . '/../../themes/' . $baseTheme . '/templates';

        if (! file_exists($baseThemePath)) {
            throw new RuntimeException($baseThemePath . ' not found');
        }

        $paths[] = $baseThemePath;
    }

    public function addGlobal($name, $value)
    {
        $this->twigEnvironment->addGlobal($name, $value);
    }
}
