<?php
namespace screenshots;

use ScreenshotsTester;

class AdminOrderCest
{
    public function snapOrders(ScreenshotsTester $I)
    {
        $I->wantTo('snap orders');
        $I->amOnPage('/admin/order');
        $I->see('Orders');
        $I->makeScreenshot('admin-order-list');

        $orderNumberSelector = '//div[contains(@class,"order-number")][1]';
        $orderNumber = $I->grabTextFrom($orderNumberSelector);
        $I->click($orderNumberSelector);
        $I->see('Order #' . $orderNumber);
        $I->makeScreenshot('admin-order-view');

        $I->click('Ship');
        $I->see('Items to Ship');
        $I->makeScreenshot('admin-order-add-shipment');

        $I->click('Create Shipping Label');
        $I->see('Parcel Dimensions');
        $I->fillField('Length (in)', 9);
        $I->fillField('Width (in)', 9);
        $I->fillField('Height (in)', 9);
        $I->click('Get Shipping Rates');
        $I->see('Shipping Rates');
        $I->makeScreenshot('admin-order-add-shipment-label');

        $I->click('Buy Shipping Label');
        $I->see('Added Shipping Label');
        $I->makeScreenshot('admin-order-add-shipment-label-purchased');

        $I->click('Ship');
        $I->see('Items to Ship');

        $I->click('Create with Tracking Code');
        $I->selectOption('Carrier', 'UPS');
        $I->fillField('Tracking Code', '1Z9999999999999999');
        $I->makeScreenshot('admin-order-add-shipment-tracking-code');

        $I->click('Create Shipment');
        $I->see('Added Tracking Code');
        $I->see('Shipped', '.order-status');
        $I->makeScreenshot('admin-order-shipments');
    }
}
