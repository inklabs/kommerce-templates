<?php
namespace screenshots;

use ScreenshotsTester;

class AdminSalesTaxRulesCest
{
    public function snapProducts(ScreenshotsTester $I)
    {
        $I->wantTo('snap sales tax rules');
        $I->amOnPage('/admin/settings/sales-tax');
        $I->see('Sales Tax Rules');
        $I->makeScreenshot('admin-sales-tax-rules-view');

        $I->click('Zipcode');
        $I->makeScreenshot('admin-sales-tax-rules-zipcode');

        $I->click('Zipcode Range');
        $I->makeScreenshot('admin-sales-tax-rules-zipcode-range');

        $I->click('State');
        $I->makeScreenshot('admin-sales-tax-rules-state');
    }
}
