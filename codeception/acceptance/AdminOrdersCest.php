<?php

class AdminOrderCest
{
    public function viewAllOrders(AcceptanceTester $I)
    {
        $I->wantTo('view all orders');
        $I->amOnPage('/admin/order');
        $I->see('Orders');
    }
}
