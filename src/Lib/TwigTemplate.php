<?php
namespace inklabs\KommerceTemplates\Lib;

use RuntimeException;
use Twig_Environment;
use Twig_Extensions_Extension_I18n;
use Twig_Extensions_Extension_Text;
use Twig_Loader_Filesystem;
use Twig_TemplateInterface;

class TwigTemplate
{
    /** @var Twig_Environment */
    private $twigEnvironment;
    /**
     * @var TwigThemeConfig
     */
    private $themeConfig;

    /**
     * @param TwigThemeConfig $themeConfig
     * @param CSRFTokenGeneratorInterface $csrfTokenGenerator
     * @param RouteUrlInterface $routeUrl
     * @param string $timezone
     * @param string $dateFormat
     * @param string $timeFormat
     */
    public function __construct(
        TwigThemeConfig $themeConfig,
        CSRFTokenGeneratorInterface $csrfTokenGenerator,
        RouteUrlInterface $routeUrl,
        $timezone,
        $dateFormat = 'F j, Y',
        $timeFormat = 'g:i a T'
    ) {
        $this->themeConfig = $themeConfig;
        $twigLoader = new Twig_Loader_Filesystem($themeConfig->getTwigTemplatePaths());

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

        $this->addMacros();
    }

    public function enableDebug()
    {
        $this->twigEnvironment->enableDebug();
    }

    public function addGlobal($name, $value)
    {
        $this->twigEnvironment->addGlobal($name, $value);
    }

    private function addMacros()
    {
        foreach ($this->getPathMacros() as $name => $path) {
            $this->twigEnvironment->addGlobal(
                $name,
                $this->twigEnvironment->loadTemplate($path)
            );
        }
    }

    /**
     * @return \Generator
     */
    private function getPathMacros()
    {
        foreach (array_reverse($this->themeConfig->getTwigTemplatePaths()) as $path) {
            $pathMacros = glob($path . '/macros/*');

            foreach ($pathMacros as $pathMacro) {
                $name = basename($pathMacro, '.twig');

                $filename = basename($pathMacro);
                yield $name => 'macros/' . $filename;
            }
        }
    }

    public function render($name, $context)
    {
        return $this->twigEnvironment
            ->render($name, $context);
    }
}
