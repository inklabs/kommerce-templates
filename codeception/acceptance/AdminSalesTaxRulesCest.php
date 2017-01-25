<?php

class AdminSalesTaxRulesCest
{
    public function viewAllSettings(AcceptanceTester $I)
    {
        $I->wantTo('view sales tax settings');
        $I->amOnPage('/admin/settings/sales-tax');
        $I->see('Sales Tax Rules');
    }
}
