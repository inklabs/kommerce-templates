<?php

class AdminOptionCest
{
    public function viewAllOptions(AcceptanceTester $I)
    {
        $I->wantTo('view all options');
        $I->amOnPage('/admin/option');
        $I->see('Options');
    }

    public function crudOption(AcceptanceTester $I)
    {
        $I->wantTo('create/update/delete option');
        $I->amOnPage('/admin/option');
        $I->see('Options');

        $name = 'Test Option';

        // Create
        $I->click('New Option');
        $I->see('New Option', 'title');
        $I->see('New Option', 'h3');
        $I->fillField('Name', $name);
        $I->click('Create');
        $I->see('Option has been created');
        $I->see($name, 'title');
        $I->seeInField('Name', $name);

        // Update
        $description = 'lorem ipsum';
        $I->fillField('Description', $description);
        $I->click('Save');
        $I->see('Option has been saved');
        $I->seeInField('Description', $description);

        // Add/Delete Option Value
        $skuOV = 'OV1';
        $nameOV = 'Test Option Value';
        $unitPriceOV = '4.32';
        $shippingWeightOV = '16';
        $sortOrderOV = '2';
        $I->click('Option Values');
        $I->fillField('SKU', $skuOV);
        $I->fillField('Name', $nameOV);
        $I->fillField('Unit Price', $unitPriceOV);
        $I->fillField('Shipping Weight', $shippingWeightOV);
        $I->fillField('Sort Order', $sortOrderOV);
        $I->click('Add');
        $I->see($skuOV, 'table');
        $I->see($name, 'table');
        $I->see($unitPriceOV, 'table');
        $I->see($shippingWeightOV, 'table');
        $I->see($sortOrderOV, 'table');
        $I->click('table tr:nth-child(1) .delete-option-value > button');
        $I->see('Success deleting option value');

        // Delete
        $I->click('Delete Option');
        $I->see('Success removing option');
    }
}
