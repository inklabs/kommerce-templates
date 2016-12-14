<?php
namespace screenshots;

use ScreenshotsTester;

class AdminProductCest
{
    public function snapProducts(ScreenshotsTester $I)
    {
        $I->wantTo('snap products');
        $I->amOnPage('/admin/product');
        $I->see('Products');
        $I->makeScreenshot('admin-product-list');

        $productNameSelector = 'table > tbody > tr:nth-child(1) > td:nth-child(3) > a';
        $productName = $I->grabTextFrom($productNameSelector);
        $I->click($productNameSelector);
        $I->see($productName);
        $I->makeScreenshot('admin-product-edit');

        $I->click('Images', '.nav-tabs');
        $I->makeScreenshot('admin-product-images');

        $I->click('Tags', '.nav-tabs');
        $I->makeScreenshot('admin-product-tags');

        $I->click('Options', '.nav-tabs');
        $I->makeScreenshot('admin-product-options');

        $I->click('Quantity Discounts', '.nav-tabs');
        $I->makeScreenshot('admin-product-quantity-discounts');
    }
}
