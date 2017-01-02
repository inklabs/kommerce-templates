<?php
namespace screenshots;

use ScreenshotsTester;

class AdminOptionCest
{
    public function snapProducts(ScreenshotsTester $I)
    {
        $I->wantTo('snap options');
        $I->amOnPage('/admin/option');
        $I->see('Options');
        $I->makeScreenshot('admin-option-list');

        $optionNameSelector = 'table > tbody > tr:nth-child(1) > td:nth-child(1) > a';
        $optionName = $I->grabTextFrom($optionNameSelector);
        $I->click($optionNameSelector);
        $I->see($optionName);
        $I->makeScreenshot('admin-option-edit');

        $I->click('Option Values', '.nav-tabs');
        $I->makeScreenshot('admin-option-option-values');

        $I->click('Option Products', '.nav-tabs');
        $I->makeScreenshot('admin-option-option-products');

        $I->click('Tags', '.nav-tabs');
        $I->makeScreenshot('admin-option-tags');
    }
}
