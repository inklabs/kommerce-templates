<?php

class AdminUserCest
{
    public function viewAllUsers(AcceptanceTester $I)
    {
        $I->wantTo('view all users');
        $I->amOnPage('/admin/user');
        $I->see('Users');
    }
}
