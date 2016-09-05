<?php

class AdminCouponCest
{
    public function viewAllCoupons(AcceptanceTester $I)
    {
        $I->wantTo('view all coupons');
        $I->amOnPage('/admin/promotion/coupon');
        $I->see('Coupons');
    }
}
