<?php

class AdminOptionCest
{
    public function viewAllOptions(AcceptanceTester $I)
    {
        $I->wantTo('view all options');
        $I->amOnPage('/admin/option');
        $I->see('Options');
    }
}
