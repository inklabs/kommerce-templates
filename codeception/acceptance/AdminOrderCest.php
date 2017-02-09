<?php

class AdminOrderCest
{
    public function accessDeniedForAnonymousUser(AcceptanceTester $I)
    {
        $I->wantTo('ensure anonymous users cannot access the admin panel');
        $I->amOnPage('/admin/order');
        $I->seeAdminLoginPage();
    }

    public function viewAllOrders(AcceptanceTester $I)
    {
        $I->wantTo('view all orders');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/order');
        $I->see('Orders', 'h1');
    }

    public function addShipmentToNewOrder(AcceptanceTester $I)
    {
        $I->wantTo('add shipment to new order');
        $I->addProductToCartAndCheckout();
        $orderId = $I->grabAttributeFrom('#new-order-number', 'data-order-id');
        $referenceNumber = $I->grabAttributeFrom('#new-order-number', 'data-reference-number');

        $I->loginAsAdmin();
        $I->amOnPage('/admin/order/view/' . $orderId);
        $I->see('Order #' . $referenceNumber);
        $I->see('Pending', '.order-status');

        $I->addShipmentTrackingCode();
        $I->buyShippingLabel();
    }
}
