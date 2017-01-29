<?php
namespace inklabs\KommerceTemplates\Lib;

use Twig_Environment;
use Twig_Extension_Profiler;
use Twig_Extensions_Extension_I18n;
use Twig_Extensions_Extension_Text;
use Twig_Loader_Filesystem;
use Twig_Profiler_Dumper_Html;
use Twig_Profiler_Profile;

class TwigTemplate
{
    /** @var Twig_Environment */
    private $twigEnvironment;

    /** @var Twig_Profiler_Profile|null */
    private $profile;

    /**
     * @param TwigThemeConfig $storeThemeConfig
     * @param TwigThemeConfig $adminThemeConfig
     * @param CSRFTokenGeneratorInterface $csrfTokenGenerator
     * @param RouteUrlInterface $routeUrl
     * @param string $timezone
     * @param string $dateFormat
     * @param string $timeFormat
     * @param bool $profilerEnabled
     * @param bool $debugEnabled
     */
    public function __construct(
        TwigThemeConfig $storeThemeConfig,
        TwigThemeConfig $adminThemeConfig,
        CSRFTokenGeneratorInterface $csrfTokenGenerator,
        RouteUrlInterface $routeUrl,
        $timezone,
        $dateFormat = 'F j, Y',
        $timeFormat = 'g:i a T',
        $profilerEnabled = false,
        $debugEnabled = false
    ) {
        $twigLoader = new Twig_Loader_Filesystem();
        $twigLoader->setPaths($adminThemeConfig->getTwigTemplatePaths(), 'admin');
        $twigLoader->setPaths($storeThemeConfig->getTwigTemplatePaths(), 'store');

        $this->twigEnvironment = new Twig_Environment($twigLoader);

        $this->twigEnvironment->addglobal(
            'config',
            [
                'timezone' => $timezone
            ]
        );

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

        if ($profilerEnabled) {
            $this->profile = new Twig_Profiler_Profile();
            $this->twigEnvironment->addExtension(new Twig_Extension_Profiler($this->profile));
        }

        if ($debugEnabled) {
            $this->twigEnvironment->enableDebug();
        }

        $this->addMacros($storeThemeConfig, 'store');
        $this->addMacros($adminThemeConfig, 'admin');
    }

    /**
     * @return string
     */
    public function getProfilerDumpHtml()
    {
        $dumper = new Twig_Profiler_Dumper_Html();
        return $dumper->dump($this->profile);
    }

    public function addGlobal($name, $value)
    {
        $this->twigEnvironment->addGlobal($name, $value);
    }

    /**
     * @param TwigThemeConfig $themeConfig
     * @param string $themeNamespace
     */
    private function addMacros(TwigThemeConfig $themeConfig, $themeNamespace)
    {
        foreach ($this->getPathMacros($themeConfig, $themeNamespace) as $name => $path) {
            $this->twigEnvironment->addGlobal(
                $name,
                $this->twigEnvironment->loadTemplate($path)
            );
        }
    }

    /**
     * @param TwigThemeConfig $themeConfig
     * @param string $themeNamespace
     * @return \Generator
     */
    private function getPathMacros(TwigThemeConfig $themeConfig, $themeNamespace)
    {
        foreach (array_reverse($themeConfig->getTwigTemplatePaths()) as $path) {
            $pathMacros = glob($path . '/macros/*');

            foreach ($pathMacros as $pathMacro) {
                $name = basename($pathMacro, '.twig');

                $filename = basename($pathMacro);
                yield $name => '@' . $themeNamespace . '/macros/' . $filename;
            }
        }
    }

    public function render($name, $context)
    {
        $content = $this->twigEnvironment->render($name, $context);

        if ($this->profile !== null) {
            $content .= $this->getProfilerDumpHtml();
        }

        return $content;
    }
}
