<?php

class AdminProductCest
{
    public function viewAllProducts(AcceptanceTester $I)
    {
        $I->wantTo('view all products');
        $I->amOnPage('/admin/product');
        $I->see('Products');
    }
}
