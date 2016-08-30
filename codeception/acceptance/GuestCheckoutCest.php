<?php

class GuestCheckoutCest
{
    const SHIP_METHOD_SELECTOR = 'input[class="ship-method"]:nth-child(1)';

    public function addProductToCartAndCheckout(AcceptanceTester $I)
    {
        $I->wantTo('add a product to the cart and checkout');
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
        $option = $I->grabAttributeFrom(self::SHIP_METHOD_SELECTOR, 'value');
        $shippingTotal = $I->grabAttributeFrom(self::SHIP_METHOD_SELECTOR, 'data-value');
        $I->selectOption('shipping[shipmentRateExternalId]', $option);
        $I->click('Update Total');

        $I->amOnPage('/cart');
        $I->see('Shopping Cart');
        $I->see($shippingTotal, '.cart-shipping');
        $cartTotal = $I->grabTextFrom("//tr[contains(@class,'cart-total-price')]//td[2]");

        $I->click('Secure Checkout');

        $I->see('Order Summary');
        $faker = Faker\Factory::create();

        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $streetAddress = $faker->streetAddress;
        $city = $faker->city;
        $stateAbbreviation = $faker->stateAbbr;
        $email = $faker->safeEmail;
        $zipcode = $faker->postcode;
        $nameOnCard = $firstName . ' ' . $lastName;
        $billingZipcode = $zipcode;
        $cardNumber = '4242424242424242';
        $cvc = '123';
        $month = '01';
        $year = '2020';

        $I->fillField('First Name', $firstName);
        $I->fillField('Last Name', $lastName);
        $I->fillField('Street Address', $streetAddress);
        $I->fillField('City', $city);
        $I->fillField('State', $stateAbbreviation);
        $I->fillField('Zipcode', $zipcode);
        $I->fillField('Email Address', $email);

        $I->fillField('creditCard[name]', $nameOnCard);
        $I->fillField('creditCard[zip5]', $billingZipcode);
        $I->fillField('creditCard[number]', $cardNumber);
        $I->fillField('creditCard[cvc]', $cvc);
        $I->selectOption('creditCard[expirationMonth]', $month);
        $I->selectOption('creditCard[expirationYear]', $year);

        $I->click('Place your order');
        $I->see('Your payment of ' . $cartTotal . ' has been made!');
    }

    public function addProductToCartAndCheckoutFailsFormValidation(AcceptanceTester $I)
    {
        $I->wantTo('add a product to the cart and checkout fails form validation');
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
        $option = $I->grabAttributeFrom(self::SHIP_METHOD_SELECTOR, 'value');
        $shippingTotal = $I->grabAttributeFrom(self::SHIP_METHOD_SELECTOR, 'data-value');
        $I->selectOption('shipping[shipmentRateExternalId]', $option);
        $I->click('Update Total');

        $I->amOnPage('/cart');
        $I->see('Shopping Cart');
        $I->see($shippingTotal, '.cart-shipping');
        $cartTotal = $I->grabTextFrom("//tr[contains(@class,'cart-total-price')]//td[2]");

        $I->click('Secure Checkout');

        $I->see('Order Summary');
        $faker = Faker\Factory::create();

        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $streetAddress = $faker->streetAddress;
        $city = $faker->city;
        $stateAbbreviation = $faker->stateAbbr;
        $email = $faker->safeEmail;
        $zipcode = 'xyz';
        $nameOnCard = $firstName . ' ' . $lastName;
        $billingZipcode = $zipcode;
        $cardNumber = '4242424242424242';
        $cvc = '123';
        $month = '01';
        $year = '2020';

        $I->fillField('First Name', $firstName);
        $I->fillField('Last Name', $lastName);
        $I->fillField('Street Address', $streetAddress);
        $I->fillField('City', $city);
        $I->fillField('State', $stateAbbreviation);
        $I->fillField('Zipcode', $zipcode);
        $I->fillField('Email Address', $email);

        $I->fillField('creditCard[name]', $nameOnCard);
        $I->fillField('creditCard[zip5]', $billingZipcode);
        $I->fillField('creditCard[number]', $cardNumber);
        $I->fillField('creditCard[cvc]', $cvc);
        $I->selectOption('creditCard[expirationMonth]', $month);
        $I->selectOption('creditCard[expirationYear]', $year);

        $I->click('Place your order');
        $I->see('Must be a valid 5 digit postal code');
    }
}
