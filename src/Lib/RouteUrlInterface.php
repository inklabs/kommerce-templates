<?php
namespace inklabs\KommerceTemplates\Lib;

interface RouteUrlInterface
{
    /**
     * Generate a URL to a named route.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     * @return string
     */
    function getRoute($name, $parameters = [], $absolute = true);
}
