<?php
namespace screenshots;

use ScreenshotsTester;

class AdminAdHocShipmentCest
{
    public function snapProducts(ScreenshotsTester $I)
    {
        $I->wantTo('snap ad hoc shipments');
        $I->amOnPage('/admin/tools/ad-hoc-shipment/new');
        $I->see('New Ad Hoc Shipment');

        $I->fillField('#fromAddress-firstName', 'John');
        $I->fillField('#fromAddress-lastName', 'Doe');
        $I->fillField('#fromAddress-company', 'Acme LTD');
        $I->fillField('#fromAddress-address1', '123 any');
        $I->fillField('#fromAddress-address2', 'Ste 3');
        $I->fillField('#fromAddress-city', 'Santa Monica');
        $I->fillField('#fromAddress-state', 'CA');
        $I->fillField('#fromAddress-zip5', '90401');

        $I->fillField('#toAddress-firstName', 'Jane');
        $I->fillField('#toAddress-lastName', 'Doe');
        $I->fillField('#toAddress-address1', '50 FM 2440');
        $I->fillField('#toAddress-city', 'Mexia');
        $I->fillField('#toAddress-state', 'TX');
        $I->fillField('#toAddress-zip5', '76667');

        $I->fillField('#shipment-weightLbs', '2.6');
        $I->fillField('#shipment-length', '6');
        $I->fillField('#shipment-width', '6');
        $I->fillField('#shipment-height', '6');

        $I->click('Get Shipping Rates');
        $I->makeScreenshot('admin-ad-hoc-shipment-new');

        $I->click('Buy Shipping Label');
        $I->makeScreenshot('admin-ad-hoc-shipment-view');
    }
}
