<?php

class AdminSettingCest
{
    public function viewAllSettings(AcceptanceTester $I)
    {
        $I->wantTo('view all settings');
        $I->amOnPage('/admin/settings');
        $I->see('Settings');
    }
}
