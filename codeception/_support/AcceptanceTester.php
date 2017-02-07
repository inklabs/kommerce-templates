<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    const SHIP_METHOD_SELECTOR = 'input[class="ship-method"]:nth-child(1)';
    const ADMIN_EMAIL = 'aaron@example.com';
    const ADMIN_PASS = 'Test123!';

    public function seeAccessDenied()
    {
        $I = $this;
        $I->see('Access Denied');
    }

    /**
     * Define custom actions here
     */
    public function addProductToCart()
    {
        $I = $this;
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
    }

    public function estimateShippingAndTax()
    {
        $I = $this;
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
    }

    public function enterCheckoutDetails()
    {
        $I = $this;
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
    }

    public function addProductToCartAndCheckout()
    {
        $I = $this;
        $I->addProductToCart();
        $I->estimateShippingAndTax();
        $cartTotal = $I->grabTextFrom("//tr[contains(@class,'cart-total-price')]//td[2]");

        $I->click('Secure Checkout');

        $I->enterCheckoutDetails();

        $I->click('Place your order');
        $I->see('Your payment of ' . $cartTotal . ' has been made!');
    }

    public function addShipmentTrackingCode()
    {
        $I = $this;
        $I->wantTo('add a shipment tracking code to the order');
        $I->click('Ship');
        $I->click('Create with Tracking Code');
        $I->selectOption('Carrier', 'UPS');
        $I->fillField('Tracking Code', '1Z9999999999999999');
        $I->click('Create Shipment');
        $I->see('Added Tracking Code');
        $I->see('Shipped', '.order-status');
    }

    public function buyShippingLabel()
    {
        $I = $this;
        $I->click('Ship');
        $I->click('Create Shipping Label');
        $I->see('Parcel Dimensions');
        $I->fillField('Length (in)', 9);
        $I->fillField('Width (in)', 9);
        $I->fillField('Height (in)', 9);
        $I->click('Get Shipping Rates');
        $I->see('Shipping Rates');
        $I->click('Buy Shipping Label');
        $I->see('Added Shipping Label');
        $I->see('Shipped', '.order-status');
    }

    public function loginAsAdmin()
    {
        $I = $this;
        $I->amOnPage('/admin/login');
        $I->see('Please Sign In');
        $I->fillField('Email Address', self::ADMIN_EMAIL);
        $I->fillField('Password', self::ADMIN_PASS);
        $I->click('Sign In', '#login');
        $I->see('Orders');
    }
}
