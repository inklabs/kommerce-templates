<?php

class AdminTagCest
{
    public function viewAllTags(AcceptanceTester $I)
    {
        $I->wantTo('view all tags');
        $I->amOnPage('/admin/tag');
        $I->see('Tags');
    }
}
