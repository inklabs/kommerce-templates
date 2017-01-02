<?php
namespace screenshots;

use ScreenshotsTester;

class AdminTagCest
{
    public function snapProducts(ScreenshotsTester $I)
    {
        $I->wantTo('snap tags');
        $I->amOnPage('/admin/tag');
        $I->see('Tags');
        $I->makeScreenshot('admin-tag-list');

        $tagNameSelector = 'table > tbody > tr:nth-child(1) > td:nth-child(2) > a';
        $tagName = $I->grabTextFrom($tagNameSelector);
        $I->click($tagNameSelector);
        $I->see($tagName);
        $I->makeScreenshot('admin-tag-edit');

        $I->click('Images', '.nav-tabs');
        $I->makeScreenshot('admin-tag-images');

        $I->click('Options', '.nav-tabs');
        $I->makeScreenshot('admin-tag-options');

        $I->click('Products', '.nav-tabs');
        $I->makeScreenshot('admin-tag-products');
    }
}
