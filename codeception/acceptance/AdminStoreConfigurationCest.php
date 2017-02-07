<?php

class AdminStoreConfigurationCest
{
    public function accessDeniedViewingSettings(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for store configuration');
        $I->amOnPage('/admin/settings/store');
        $I->seeAccessDenied();
    }

    public function viewShipping(AcceptanceTester $I)
    {
        $I->wantTo('view shipping configuration');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/settings/store');
        $I->see('Configuration');
        $I->click('Shipping');
        $I->see('EasyPost');
    }

    public function viewPayment(AcceptanceTester $I)
    {
        $I->wantTo('view payment configuration');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/settings/store');
        $I->see('Configuration');
        $I->click('Payments');
        $I->see('Stripe');
    }
}
