<?php
namespace inklabs\KommerceTemplates\Lib;

use DateTime;
use DateTimeZone;
use inklabs\kommerce\EntityDTO\AbstractPromotionDTO;
use inklabs\kommerce\EntityDTO\AttachmentDTO;
use inklabs\kommerce\EntityDTO\AttributeDTO;
use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;
use inklabs\kommerce\EntityDTO\CatalogPromotionDTO;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\EntityDTO\ImageDTO;
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
                'boolYesNo',
                function ($boolean) {
                    return $boolean ? 'Yes' : 'No';
                }
            ),
            new Twig_SimpleFilter(
                'displayPrice',
                function ($price) {
                    return '$' . number_format(($price / 100), 2);
                }
            ),
            new Twig_SimpleFilter(
                'floatPrice',
                function ($price, $nullDisplayValue = null) {
                    if ($nullDisplayValue !== null && $price === null) {
                        return $nullDisplayValue;
                    }

                    return number_format(($price / 100), 2, null, '');
                }
            ),
            new Twig_SimpleFilter(
                'floatPercent',
                function ($percent, $nullDisplayValue = null) {
                    if ($nullDisplayValue !== null && $percent === null) {
                        return $nullDisplayValue;
                    }

                    return number_format($percent, 2, null, '');
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
                'formatInputDate',
                function ($timestamp = null) {
                    if ($timestamp === null) {
                        return '';
                    }

                    $format = 'm/d/Y';
                    $output = new DateTime();
                    $output->setTimestamp($timestamp);
                    $output->setTimezone(new DateTimeZone($this->timezone));

                    return $output->format($format);
                }
            ),
            new Twig_SimpleFilter(
                'formatInputTime',
                function ($timestamp = null) {
                    if ($timestamp === null) {
                        return '';
                    }

                    $format = 'g:i:sa';
                    $output = new DateTime();
                    $output->setTimestamp($timestamp);
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
                function ($theme, $section, $path) {
                    return $this->routeUrl->getRoute(
                        'asset.serve',
                        [
                            'theme' => $theme,
                            'section' => $section,
                            'path' => $path,
                        ]
                    );
                }
            ),
            new Twig_SimpleFunction(
                'scssUrl',
                function ($theme, $section, $file, $formatter = 'compact') {
                    return $this->routeUrl->getRoute(
                        'scss.serve',
                        [
                            'theme' => $theme,
                            'section' => $section,
                        ]
                    ) . '?p=' . $file . '&formatter=' . $formatter;
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
                'adminAttributeUrl',
                function (AttributeDTO $attributeDTO) {
                    return $this->routeUrl->getRoute(
                        'admin.attribute.edit',
                        [
                            'attributeId' => $attributeDTO->id->getHex(),
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
                'adminCartPriceRuleUrl',
                function (CartPriceRuleDTO $cartPriceRuleDTO) {
                    return $this->routeUrl->getRoute(
                        'admin.cart-price-rule.edit',
                        [
                            'cartPriceRuleId' => $cartPriceRuleDTO->id->getHex(),
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
                'adminCatalogPromotionUrl',
                function (CatalogPromotionDTO $catalogPromotionDTO) {
                    return $this->routeUrl->getRoute(
                        'admin.catalog-promotion.edit',
                        [
                            'catalogPromotionId' => $catalogPromotionDTO->id->getHex(),
                        ]
                    );
                }
            ),
            new Twig_SimpleFunction(
                'imageUrl',
                function (ImageDTO $imageDTO) {
                    $imagePath = $imageDTO->path;

                    if ($imagePath === null) {
                        return $this->getPlaceholderUrl();
                    }

                    if ($this->containsExternalUrl($imagePath)) {
                        return $imagePath;
                    }

                    return $this->routeUrl->getRoute(
                        'image.path',
                        [
                            'imagePath' => $imagePath,
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
                        'image.path',
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
                        'image.path',
                        [
                            'imagePath' => $imagePath,
                        ]
                    );
                }
            ),
            new Twig_SimpleFunction(
                'attachmentImageUrl',
                function (AttachmentDTO $attachmentDTO) {
                    $imagePath = $attachmentDTO->uri;

                    if ($imagePath === null) {
                        return $this->getPlaceholderUrl();
                    }

                    if ($this->containsExternalUrl($imagePath)) {
                        return $imagePath;
                    }

                    return $this->routeUrl->getRoute(
                        'image.path',
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
            new Twig_SimpleFunction(
                'getTimezones',
                function () {
                    return [
                        'UTC' => '(GMT+00:00) UTC Time',
                        'Pacific/Honolulu' => '(GMT-10:00) Hawaii Time',
                        'America/Anchorage' => '(GMT-09:00) Alaska Time',
                        'America/Los_Angeles' => '(GMT-08:00) Pacific Time',
                        'America/Denver' => '(GMT-07:00) Mountain Time',
                        'America/Phoenix' => '(GMT-07:00) Mountain Time - Arizona',
                        'America/Chicago' => '(GMT-06:00) Central Time',
                        'America/New_York' => '(GMT-05:00) Eastern Time',
                    ];
                }
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
                'theme' => 'foundation',
                'section' => 'store',
                'path' => 'img/placeholder.png',
            ]
        );
    }
}
