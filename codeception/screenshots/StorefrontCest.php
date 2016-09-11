<?php

class StorefrontCest
{
    public function snapProductCheckout(ScreenshotsTester $I)
    {
        $I->wantTo('take snapshots');
        $I->amOnPage('/t');
        $I->see('Tags');
        $I->makeScreenshot('tag-list');

        $tagName = $I->grabTextFrom("//div[contains(@class,'tag-name')][1]");
        $I->click("//div[contains(@class,'tag-container')][1]//a");
        $I->see($tagName);
        $I->makeScreenshot('tag-view');

        $productName = $I->grabTextFrom("//div[contains(@class,'product-name')][1]");
        $I->click("//div[contains(@class,'product-container')][1]//a");
        $I->see($productName);
        $I->makeScreenshot('product-view');

        $I->click('Add to Cart');
        $I->see('1 item added to Cart');
        $I->makeScreenshot('added-to-cart');

        $I->click('View Cart');
        $I->see('Shopping Cart');
        $I->makeScreenshot('cart');
    }
}
