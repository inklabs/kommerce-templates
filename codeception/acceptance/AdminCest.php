<?php

class AdminCest
{
    public function loginAndLogout(AcceptanceTester $I)
    {
        $I->wantTo('login and logout as an admin');
        $I->loginAsAdmin();

        $I->click('Sign Out');
        $I->seeCurrentUrlEquals('/admin/login');
    }
}
