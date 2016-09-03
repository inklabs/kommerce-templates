<?php

class AdminCouponCest
{
    public function viewAllCoupons(AcceptanceTester $I)
    {
        $I->wantTo('view all coupons');
        $I->amOnPage('/admin/coupon');
        $I->see('Coupons');
    }
}
