<?php

class TagCest
{
    public function viewAllTags(AcceptanceTester $I)
    {
        $I->wantTo('view all tags');
        $I->amOnPage('/t');
        $I->see('Tags');
        //$I->dontSeeHttpHeader('Set-Cookie');
    }

    public function viewProductFromTagPage(AcceptanceTester $I)
    {
        $I->wantTo('view a product from tag page');
        $I->amOnPage('/t');
        $tagName = $I->grabTextFrom("//div[contains(@class,'tag-name')][1]");
        $I->click("//div[contains(@class,'tag-container')][1]//a");
        $I->see($tagName);

        $productName = $I->grabTextFrom("//div[contains(@class,'product-name')][1]");
        $I->click("//div[contains(@class,'product-container')][1]//a");
        $I->see($productName);
    }
}
