<?php

class GuestCheckoutCest
{
    public function addProductToCart(AcceptanceTester $I)
    {
        $I->wantTo('add a product to the cart');
        $I->amOnPage('/');
        $productName = $I->grabTextFrom("//div[contains(@class,'product-name')][1]");
        $I->click("//div[contains(@class,'product-container')][1]//a");

        $I->see($productName);
        $I->click('Add to Cart');

        $I->see('1 item added to Cart');
        $I->see($productName);

        $I->click('View Cart');
        $I->see('Shopping Cart');
        $I->see($productName);
    }
}
