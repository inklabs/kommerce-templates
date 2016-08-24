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

    /**
     * @param string $rootScssDirectory
     * @param string $baseTheme
     * @param array $paths
     * @param string | null $formatter
     * @param string | null $cacheDir
     */
    public function __construct(
        $rootScssDirectory,
        $baseTheme = 'base-bootstrap',
        $paths = [],
        $formatter = 'compressed',
        $cacheDir = null
    ) {
        $this->addImportPath($paths, __DIR__ . '/../../themes/base/scss');
        $this->addImportPath($paths, __DIR__ . '/../../themes/' . $baseTheme . '/scss');

        if ($baseTheme === 'base-bootstrap') {
            $this->addImportPath($paths, __DIR__ . '/../../../../../vendor/twbs/bootstrap-sass/assets/stylesheets');
        }

        $scssCompiler = new Compiler();
        $scssCompiler->setImportPaths($paths);

        $this->salt = $rootScssDirectory . json_encode($paths);

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

    public function serve()
    {
        //$this->salt = time();
        $this->server->serve($this->salt);
    }

        /**
     * @param string[] $paths
     * @param string $baseThemePath
     */
    private function addImportPath(array & $paths, $baseThemePath)
    {
        if (! file_exists($baseThemePath)) {
            throw new RuntimeException($baseThemePath . ' not found');
        }

        $paths[] = $baseThemePath;
    }
}
