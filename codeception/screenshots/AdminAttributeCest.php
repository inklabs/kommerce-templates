<?php
namespace screenshots;

use ScreenshotsTester;

class AdminAttributeCest
{
    public function snapProducts(ScreenshotsTester $I)
    {
        $I->wantTo('snap attributes');
        $I->amOnPage('/admin/attribute');
        $I->see('Attributes');
        $I->makeScreenshot('admin-attribute-list');

        $attributeNameSelector = 'table > tbody > tr:nth-child(1) > td:nth-child(1) > a';
        $attributeName = $I->grabTextFrom($attributeNameSelector);
        $I->click($attributeNameSelector);
        $I->see($attributeName);
        $I->makeScreenshot('admin-attribute-edit');

        $I->click('Attribute Values', '.nav-tabs');
        $I->makeScreenshot('admin-attribute-attribute-values');

        $editProductAttributeSelector = 'table > tbody > tr:nth-child(1)';
        $I->click('Edit', $editProductAttributeSelector);
        $I->see('Attribute Value -');
        $I->makeScreenshot('admin-attribute-attribute-value-edit');

        $I->click('Products', '.nav-tabs');
        $I->makeScreenshot('admin-attribute-attribute-value-products');
    }
}
