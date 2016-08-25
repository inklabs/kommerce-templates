<?php

class HomepageCest
{
    public function viewHomepage(AcceptanceTester $I)
    {
        $I->wantTo('view the homepage');
        $I->amOnPage('/');
        $I->see('Welcome');
        //$I->dontSeeHttpHeader('Set-Cookie');
    }
}
