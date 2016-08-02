<?php
namespace inklabs\KommerceTemplates\Lib;

interface CSRFTokenGeneratorInterface
{
    /**
     * @return string
     */
    public function getToken();
}
