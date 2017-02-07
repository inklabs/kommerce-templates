<?php

class AdminCartPriceRuleCest
{
    public function accessDeniedViewingCartPriceRules(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for cart price rules');
        $I->amOnPage('/admin/promotion/cart-price-rule');
        $I->seeAccessDenied();
    }

    public function crudCartPriceRule(AcceptanceTester $I)
    {
        $I->wantTo('create/update/delete cart price rule');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/promotion/cart-price-rule');
        $I->see('Cart Price Rules', 'h1');

        $name = 'Test CartPriceRule';
        $maxRedemptions = '100';
        $startDate = '01/01/2017';
        $endDate = '12/31/2017';

        // Create
        $I->click('New Cart Price Rule');
        $I->see('New Cart Price Rule', 'title');
        $I->see('New Cart Price Rule', 'h3');
        $I->fillField('Name', $name);
        $I->fillField('Max Redemptions', $maxRedemptions);
        $I->checkOption('Reduces Tax Subtotal');
        $I->fillField('Start', $startDate);
        $I->fillField('End', $endDate);
        $I->click('Create');
        $I->see('Cart Price Rule has been created');
        $I->see($name, 'title');
        $I->seeInField('Name', $name);
        $I->seeInField('Max Redemptions', $maxRedemptions);
        $I->seeCheckboxIsChecked('Reduces Tax Subtotal');
        $I->seeInField('Start', $startDate);
        $I->seeInField('End', $endDate);

        // Update
        $name = 'Test CartPriceRule 2';
        $I->fillField('Name', $name);
        $I->click('Save');
        $I->seeInField('Name', $name);

        // Delete
        $I->click('Delete Cart Price Rule');
        $I->see('Success removing cart price rule');
    }
}
