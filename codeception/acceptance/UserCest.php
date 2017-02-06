<?php

class UserCest
{
    public function loginAndLogout(AcceptanceTester $I)
    {
        $I->wantTo('login and logout as a user');
        $I->amOnPage('/');
        $I->click('Sign In');
        $I->see('Please Sign In');
        $I->fillField('Email Address', 'charles@example.com');
        $I->fillField('Password', 'Test123!');
        $I->click('Sign In', '#login');
        $I->see('Your Account');
        $I->see('Charles Customer');

        $I->click('Sign Out');
        $I->seeCurrentUrlEquals('');
    }
}
