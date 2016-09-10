<?php

class AdminOrderCest
{
    public function viewAllOrders(AcceptanceTester $I)
    {
        $I->wantTo('view all orders');
        $I->amOnPage('/admin/order');
        $I->see('Orders');
    }

    public function addShipmentToNewOrder(AcceptanceTester $I)
    {
        $I->addProductToCartAndCheckout();
        $orderId = $I->grabAttributeFrom('#new-order-number', 'data-order-id');
        $referenceNumber = $I->grabAttributeFrom('#new-order-number', 'data-reference-number');

        $I->amOnPage('/admin/order/view/' . $orderId);
        $I->see('Order #' . $referenceNumber);
        $I->see('Pending', '.order-status');

        $I->click('Ship');
        $I->click('Create with Tracking Code');
        $I->selectOption('Carrier', 'UPS');
        $I->fillField('Tracking Code', '1Z9999999999999999');
        $I->click('Create Shipment');
        $I->see('Added Tracking Code');
        $I->see('Shipped', '.order-status');
    }
}
