<?php

use inklabs\kommerce\Lib\Uuid;

class AdminProductCest
{
    public function accessDeniedViewingProducts(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for products');
        $I->amOnPage('/admin/product');
        $I->seeAdminLoginPage();
    }

    public function crudProduct(AcceptanceTester $I)
    {
        $I->wantTo('create/update/delete product');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/product');
        $I->see('Products');

        $name = 'Test Product';
        $sku = 'TST-PRD-' . Uuid::uuid4();
        $unitPrice = '5.79';
        $quantity = '11';
        $shippingWeightOz = '24';

        // Create
        $I->click('New Product');
        $I->see('New Product', 'title');
        $I->see('New Product', 'h3');
        $I->fillField('Name', $name);
        $I->fillField('Unit Price', $unitPrice);
        $I->fillField('Quantity', $quantity);
        $I->fillField('Shipping Weight (oz)', $shippingWeightOz);
        $I->checkOption('Is Active');
        $I->checkOption('Is Visible');
        $I->fillField('SKU', $sku);
        $I->fillField('Description', 'lorem ipsum');
        $I->click('Create');
        $I->see('Product has been created');
        $I->see($name, 'title');
        $I->seeInField('Name', $name);
        $I->seeInField('Unit Price', $unitPrice);
        $I->seeInField('Quantity', $quantity);
        $I->seeInField('Shipping Weight (oz)', $shippingWeightOz);
        $I->seeCheckboxIsChecked('Is Active');
        $I->seeCheckboxIsChecked('Is Visible');
        $I->dontSeeCheckboxIsChecked('Is Taxable');

        // Update
        $I->checkOption('Is Taxable');
        $I->click('Save');
        $I->see('Product has been saved');
        $I->seeCheckboxIsChecked('Is Taxable');

        // Delete
        $I->click('Delete Product');
        $I->see('Success removing product');
    }
}
