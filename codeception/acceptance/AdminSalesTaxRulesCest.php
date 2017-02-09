<?php

class AdminSalesTaxRulesCest
{
    public function accessDeniedViewingSettings(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for sales tax settings');
        $I->amOnPage('/admin/settings/sales-tax');
        $I->seeAdminLoginPage();
    }
}
