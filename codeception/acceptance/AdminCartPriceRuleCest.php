<?php

class AdminCartPriceRuleCest
{
    public function viewAllCartPriceRules(AcceptanceTester $I)
    {
        $I->wantTo('view all cart price rules');
        $I->amOnPage('/admin/promotion/cart-price-rule');
        $I->see('Cart Price Rules');
    }
}
