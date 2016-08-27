<?php

class GuestCheckoutCest
{
    public function addProductToCart(AcceptanceTester $I)
    {
        $I->wantTo('add a product to the cart');
        $I->amOnPage('/t');
        $tagName = $I->grabTextFrom("//div[contains(@class,'tag-name')][1]");
        $I->click("//div[contains(@class,'tag-container')][1]//a");

        $I->see($tagName);
        $productName = $I->grabTextFrom("//div[contains(@class,'product-name')][1]");
        $I->click("//div[contains(@class,'product-container')][1]//a");

        $I->see($productName);
        $I->click('Add to Cart');

        $I->see('1 item added to Cart');
        $I->see($productName);
        $I->click('View Cart');

        $I->see('Shopping Cart');
        $I->see($productName);
        $I->click('Estimate Shipping & Tax');

        $I->see('Estimate Shipping & Tax');
        $I->fillField('Zipcode', 90401);
        $I->click('Get Quote');

        $I->see('Choose your delivery option');
        //$option = $I->grabValueFrom("(//input[contains(@class, 'ship-method')])[1]");
        $option = $I->grabAttributeFrom('input[class="ship-method"]:nth-child(1)', 'value');
        $I->selectOption('shipping[shipmentRateExternalId]', $option);
        $I->click('Update Total');

        $I->click('Secure Checkout');

        $I->see('Order Summary');
    }
}
