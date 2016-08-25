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

    public function viewProductFromHomepage(AcceptanceTester $I)
    {
        $I->wantTo('view a product from homepage');
        $I->amOnPage('/');
        $productName = $I->grabTextFrom("//div[contains(@class,'product-name')][1]");
        $I->click("//div[contains(@class,'product-container')][1]//a");
        $I->see($productName);
        //$I->dontSeeHttpHeader('Set-Cookie');
    }
}
