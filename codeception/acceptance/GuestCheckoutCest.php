<?php

class GuestCheckoutCest
{
    public function addProductToCartAndCheckout(AcceptanceTester $I)
    {
        $I->wantTo('add a product to the cart and checkout');
        $I->addProductToCartAndCheckout();
    }

    public function addProductToCartAndCheckoutFailsFormValidation(AcceptanceTester $I)
    {
        $I->wantTo('add a product to the cart and checkout fails form validation');
        $I->addProductToCart();
        $I->estimateShippingAndTax();

        $I->click('Secure Checkout');

        $I->see('Order Summary');

        $I->enterCheckoutDetails();

        $badZipcode = 'xyz';
        $I->fillField('Zipcode', $badZipcode);

        $I->click('Place your order');
        $I->see('Must be a valid 5 digit postal code');
    }
}
