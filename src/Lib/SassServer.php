<?php
namespace inklabs\KommerceTemplates\Lib;

use Leafo\ScssPhp\Compiler;
use Leafo\ScssPhp\Server;
use RuntimeException;

class SassServer
{
    /** @var string */
    private $salt;

    /** @var Server */
    private $server;

    /** @var array */
    private $paths;

    /**
     * @param string $rootScssDirectory
     * @param TwigThemeConfig $themeConfig
     * @param string | null $formatter
     * @param string | null $cacheDir
     */
    public function __construct(
        $rootScssDirectory,
        TwigThemeConfig $themeConfig,
        $formatter = 'compressed',
        $cacheDir = null
    ) {
        $scssImportPaths = $themeConfig->getScssImportPaths();

        $scssCompiler = new Compiler();
        $scssCompiler->setImportPaths($scssImportPaths);

        $this->salt = $formatter . $rootScssDirectory . json_encode($scssImportPaths);

        switch ($formatter) {
            case 'expanded':
                $scssCompiler->setFormatter(\Leafo\ScssPhp\Formatter\Expanded::class);
                break;

            case 'compact':
                $scssCompiler->setFormatter(\Leafo\ScssPhp\Formatter\Compact::class);
                break;

            case 'compressed':
                $scssCompiler->setFormatter(\Leafo\ScssPhp\Formatter\Compressed::class);
                break;
        }

        $this->server = new Server($rootScssDirectory, $cacheDir, $scssCompiler);
        $this->server->showErrorsAsCSS(true);
    }

    public function serve($resetSalt = false)
    {
        if ($resetSalt) {
            $this->salt = time();
        }

        $this->server->serve($this->salt);
    }
}
