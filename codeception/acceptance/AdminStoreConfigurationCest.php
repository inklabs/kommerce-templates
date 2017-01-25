<?php

class AdminStoreConfigurationCest
{
    public function viewAllSettings(AcceptanceTester $I)
    {
        $I->wantTo('view store configuration');
        $I->amOnPage('/admin/settings/store');
        $I->see('Configuration');
    }

    public function viewShipping(AcceptanceTester $I)
    {
        $I->wantTo('view shipping configuration');
        $I->amOnPage('/admin/settings/store');
        $I->see('Configuration');
        $I->click('Shipping');
        $I->see('EasyPost');
    }

    public function viewPayment(AcceptanceTester $I)
    {
        $I->wantTo('view payment configuration');
        $I->amOnPage('/admin/settings/store');
        $I->see('Configuration');
        $I->click('Payments');
        $I->see('Stripe');
    }
}
