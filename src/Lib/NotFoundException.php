<?php
namespace inklabs\KommerceTemplates\Lib;

use inklabs\kommerce\Exception\Kommerce400Exception;

class NotFoundException extends Kommerce400Exception
{
    public static function scssPathNotFound()
    {
        return new self('SCSS path not found');
    }

    public static function themePathNotFound()
    {
        return new self('Theme path not found');
    }

    public static function twigTemplatePathNotFound()
    {
        return new self('Twig template path not found');
    }
}
