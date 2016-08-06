<?php
namespace inklabs\KommerceTemplates\Lib;

use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\EntityDTO\TagDTO;
use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class TwigExtension extends Twig_Extension
{
    /** @var CSRFTokenGeneratorInterface */
    private $csrfTokenGenerator;

    /** @var RouteUrlInterface */
    private $routeUrl;

    public function __construct(
        CSRFTokenGeneratorInterface $csrfTokenGenerator,
        RouteUrlInterface $routeUrl
    ) {
        $this->routeUrl = $routeUrl;
        $this->csrfTokenGenerator = $csrfTokenGenerator;
    }

    /**
     * @return string The extension name
     */
    public function getName()
    {
        return 'Kommerce';
    }

    public function getGlobals()
    {
        return [
            'CSRF_TOKEN' => $this->csrfTokenGenerator->getToken(),
        ];
    }

    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('ceil', 'ceil'),
            new Twig_SimpleFilter('floor', 'floor'),
            new Twig_SimpleFilter(
                'displayPrice',
                function ($price) {
                    return '$' . number_format(($price / 100), 2);
                }
            ),
        ];
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'productUrl',
                function (ProductDTO $productDTO) {
                    return $this->routeUrl->getRoute(
                        'product.show',
                        [
                            'slug' => $productDTO->slug,
                            'productId' => $productDTO->id->getHex(),
                        ]
                    );
                }
             ),
            new Twig_SimpleFunction(
                'tagUrl',
                function (TagDTO $tagDTO) {
                    return $this->routeUrl->getRoute(
                        'tag.show',
                        [
                            'slug' => $tagDTO->slug,
                            'tagId' => $tagDTO->id->getHex(),
                        ]
                    );
                }
             ),
        ];
    }
}
