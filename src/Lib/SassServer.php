<?php
namespace inklabs\KommerceTemplates\Lib;

use Leafo\ScssPhp\Compiler;
use Leafo\ScssPhp\Server;

class SassServer
{
    /** @var string */
    private $salt;

    /** @var Server */
    private $server;

    /**
     * @param string $baseTheme
     * @param string $mainScssDirectory
     * @param string | null $bootswatchTheme
     * @param string | null $formatter
     * @param string | null $cacheDir
     */
    public function __construct(
        $mainScssDirectory,
        $baseTheme = 'base-bootstrap',
        $bootswatchTheme = 'default',
        $formatter = 'compressed',
        $cacheDir = null
    ) {
        $baseScssDirectory = __DIR__ . '/../../../../../vendor/inklabs/kommerce-templates/themes/base/scss';
        $kommerceScssDirectory = __DIR__ . '/../../../../../vendor/inklabs/kommerce-templates/themes/' . $baseTheme . '/scss';
        $bootstrapScssDirectory = __DIR__ . '/../../../../../vendor/twbs/bootstrap-sass/assets/stylesheets';
        $bootswatchScssDirectory = __DIR__ . '/../../../../../vendor/thomaspark/bootswatch/' . $bootswatchTheme;

        $importPaths[] = $baseScssDirectory;
        $importPaths[] = $kommerceScssDirectory;
        $importPaths[] = $bootstrapScssDirectory;
        $importPaths[] = $bootswatchScssDirectory;

        $scssCompiler = new Compiler();
        $scssCompiler->setImportPaths($importPaths);

        $this->salt = $mainScssDirectory . $baseTheme . $bootswatchTheme . $formatter;

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

        $this->server = new Server($mainScssDirectory, $cacheDir, $scssCompiler);
        $this->server->showErrorsAsCSS(true);
    }

    public function serve()
    {
        //$this->salt = time();
        $this->server->serve($this->salt);
    }
}
