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
        $this->paths = $paths;
        $kommerceTemplatesPath = realpath(__DIR__ . '/../..');
        $this->addImportPath($kommerceTemplatesPath . '/themes/' . $baseTheme . '/scss');

        if ($baseTheme === 'base-bootstrap') {
            $vendorPath = realpath(__DIR__ . '/../../../../../vendor');
            $this->addImportPath($vendorPath . '/twbs/bootstrap-sass/assets/stylesheets');
        }

        $this->addImportPath($kommerceTemplatesPath . '/themes/base/scss');

        $scssCompiler = new Compiler();
        $scssCompiler->setImportPaths($this->paths);

        $this->salt = $formatter . $rootScssDirectory . json_encode($paths);

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
     * @param string $baseThemePath
     */
    private function addImportPath($baseThemePath)
    {
        if (! file_exists($baseThemePath)) {
            throw new RuntimeException($baseThemePath . ' not found');
        }

        $this->paths[] = $baseThemePath;
    }
}
