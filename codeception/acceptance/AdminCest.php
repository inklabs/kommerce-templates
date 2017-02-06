<?php

class AdminCest
{
    public function loginAndLogout(AcceptanceTester $I)
    {
        $I->wantTo('login and logout as an admin');
        $I->amOnPage('/admin/login');
        $I->see('Please Sign In');
        $I->fillField('Email Address', 'aaron@example.com');
        $I->fillField('Password', 'Test123!');
        $I->click('Sign In', '#login');
        $I->see('Orders');

        $I->click('Sign Out');
        $I->seeCurrentUrlEquals('/admin/login');
    }
}
