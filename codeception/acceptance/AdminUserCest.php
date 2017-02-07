<?php

class AdminUserCest
{
    public function accessDeniedViewingUsers(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for users');
        $I->amOnPage('/admin/user');
        $I->seeAccessDenied();
    }
}
