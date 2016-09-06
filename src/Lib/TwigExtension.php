<?php
namespace inklabs\KommerceTemplates\Lib;

use DateTime;
use DateTimeZone;
use inklabs\kommerce\EntityDTO\AbstractPromotionDTO;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\EntityDTO\OptionDTO;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\Lib\Slug;
use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class TwigExtension extends Twig_Extension
{
    /** @var CSRFTokenGeneratorInterface */
    private $csrfTokenGenerator;

    /** @var RouteUrlInterface */
    private $routeUrl;

    /** @var string */
    private $dateFormat;

    /** @var string */
    private $timeFormat;

    /** @var string */
    private $timezone;

    /**
     * @param CSRFTokenGeneratorInterface $csrfTokenGenerator
     * @param RouteUrlInterface $routeUrl
     * @param string $timezone
     * @param string $dateFormat
     * @param string $timeFormat
     * @throws InvalidArgumentException
     */
    public function __construct(
        CSRFTokenGeneratorInterface $csrfTokenGenerator,
        RouteUrlInterface $routeUrl,
        $timezone,
        $dateFormat,
        $timeFormat
    ) {
        if (! $this->isValidTimezone($timezone)) {
            throw new InvalidArgumentException();
        }

        $this->routeUrl = $routeUrl;
        $this->csrfTokenGenerator = $csrfTokenGenerator;
        $this->timezone = $timezone;
        $this->dateFormat = $dateFormat;
        $this->timeFormat = $timeFormat;
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
            new Twig_SimpleFilter(
                'displayPromotionValue',
                function (AbstractPromotionDTO $promotion) {
                    if ($promotion->type->isFixed || $promotion->type->isExact) {
                        return '$' . number_format(($promotion->value / 100), 2);
                    } elseif ($promotion->type->isPercent) {
                        return $promotion->value . '%';
                    }
                }
            ),
            new Twig_SimpleFilter(
                'formatDate',
                function (DateTime $dateTime = null) {
                    if ($dateTime === null) {
                        return '';
                    }

                    $format = $this->dateFormat . ' ' . $this->timeFormat;

                    $output = clone $dateTime;
                    $output->setTimezone(new DateTimeZone($this->timezone));

                    return $output->format($format);
                }
            ),
            new Twig_SimpleFilter(
                'slug',
                function ($string) {
                    return Slug::get($string);
                }
            ),
        ];
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'assetUrl',
                function ($theme, $path) {
                    return $this->routeUrl->getRoute(
                        'asset.serve',
                        [
                            'theme' => $theme,
                            'path' => $path,
                        ]
                    );
                }
            ),
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
                'adminProductUrl',
                function (ProductDTO $productDTO) {
                    return $this->routeUrl->getRoute(
                        'admin.product.edit',
                        [
                            'productId' => $productDTO->id->getHex(),
                        ]
                    );
                }
            ),
            new Twig_SimpleFunction(
                'adminOrderUrl',
                function (OrderDTO $orderDTO) {
                    return $this->routeUrl->getRoute(
                        'admin.order.view',
                        [
                            'orderId' => $orderDTO->id->getHex(),
                        ]
                    );
                }
            ),
            new Twig_SimpleFunction(
                'adminOptionUrl',
                function (OptionDTO $optionDTO) {
                    return $this->routeUrl->getRoute(
                        'admin.option.edit',
                        [
                            'optionId' => $optionDTO->id->getHex(),
                        ]
                    );
                }
            ),
            new Twig_SimpleFunction(
                'adminTagUrl',
                function (TagDTO $tagDTO) {
                    return $this->routeUrl->getRoute(
                        'admin.tag.edit',
                        [
                            'tagId' => $tagDTO->id->getHex(),
                        ]
                    );
                }
            ),
            new Twig_SimpleFunction(
                'adminCouponUrl',
                function (CouponDTO $couponDTO) {
                    return $this->routeUrl->getRoute(
                        'admin.coupon.edit',
                        [
                            'couponId' => $couponDTO->id->getHex(),
                        ]
                    );
                }
            ),
            new Twig_SimpleFunction(
                'productImageUrl',
                function (ProductDTO $productDTO) {
                    $imagePath = $productDTO->defaultImage;

                    if ($imagePath === null) {
                        return $this->getPlaceholderUrl();
                    }

                    if ($this->containsExternalUrl($imagePath)) {
                        return $imagePath;
                    }

                    return $this->routeUrl->getRoute(
                        'product.image',
                        [
                            'imagePath' => $imagePath,
                        ]
                    );
                }
            ),
            new Twig_SimpleFunction(
                'tagImageUrl',
                function (TagDTO $tagDTO) {
                    $imagePath = $tagDTO->defaultImage;

                    if ($imagePath === null) {
                        return $this->getPlaceholderUrl();
                    }

                    if ($this->containsExternalUrl($imagePath)) {
                        return $imagePath;
                    }

                    return $this->routeUrl->getRoute(
                        'tag.image',
                        [
                            'imagePath' => $imagePath,
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
            new Twig_SimpleFunction(
                'orderUrl',
                function (OrderDTO $order) {
                    return $this->routeUrl->getRoute(
                        'user.account.view-order',
                        [
                            'orderId' => $order->id->getHex()
                        ]
                    );
                }
            ),
            new Twig_SimpleFunction(
                'routeUrl',
                function ($name, $parameters = [], $absolute = true) {
                    return $this->routeUrl->getRoute($name, $parameters, $absolute);
                }
            ),
            new Twig_SimpleFunction(
                'currentPath',
                function () {
                    return request()->path();
                }
            ),
            new Twig_SimpleFunction(
                'currentUrl',
                function () {
                    return request()->url();
                }
            ),
            new Twig_SimpleFunction(
                'htmlAttributes',
                function (array $params) {
                    $attributes = [];

                    foreach ($params as $key => $value) {
                        $attributes[] = $key . '="' . $value . '"';
                    }

                    return implode(' ', $attributes);
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
        ];
    }

    /**
     * @param string $timezone
     * @return bool
     */
    private function isValidTimezone($timezone)
    {
        return in_array($timezone, DateTimeZone::listIdentifiers(), true);
    }

    /**
     * @param string $path
     * @return bool
     */
    private function containsExternalUrl($path)
    {
        return strstr($path, '://') !== false;
    }

    private function getPlaceholderUrl()
    {
        return $this->routeUrl->getRoute(
            'asset.serve',
            [
                'theme' => 'base',
                'path' => 'img/placeholder.png',
            ]
        );
    }
}
