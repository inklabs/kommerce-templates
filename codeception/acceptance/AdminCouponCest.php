<?php

class AdminCouponCest
{
    public function accessDeniedViewingCoupons(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for coupons');
        $I->amOnPage('/admin/promotion/coupon');
        $I->seeAccessDenied();
    }

    public function crudCoupon(AcceptanceTester $I)
    {
        $I->wantTo('create/update/delete coupon');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/promotion/coupon');
        $I->see('Coupons', 'h1');

        $name = 'Test Coupon';
        $code = 'TC';
        $discountType = 'Percent';
        $discountValue = '43';
        $minOrderValue = '10.23';
        $maxOrderValue = '99.99';
        $maxRedemptions = '100';
        $startDate = '01/01/2017';
        $endDate = '12/31/2017';

        // Create
        $I->click('New Coupon');
        $I->see('New Coupon', 'title');
        $I->see('New Coupon', 'h3');
        $I->fillField('Name', $name);
        $I->fillField('Code', $code);
        $I->selectOption('Discount Type', $discountType);
        $I->fillField('Discount Value', $discountValue);
        $I->fillField('Min Order Value', $minOrderValue);
        $I->fillField('Max Order Value', $maxOrderValue);
        $I->fillField('Max Redemptions', $maxRedemptions);
        $I->checkOption('Reduces Tax Subtotal');
        $I->fillField('Start', $startDate);
        $I->fillField('End', $endDate);
        $I->click('Create');
        $I->see('Coupon has been created');
        $I->see($name, 'title');
        $I->seeInField('Name', $name);
        $I->seeInField('Code', $code);
        $I->seeOptionIsSelected('Discount Type', $discountType);
        $I->seeInField('Discount Value', $discountValue);
        $I->seeInField('Min Order Value', $minOrderValue);
        $I->seeInField('Max Order Value', $maxOrderValue);
        $I->seeInField('Max Redemptions', $maxRedemptions);
        $I->dontSeeCheckboxIsChecked('Flag Free Shipping');
        $I->seeCheckboxIsChecked('Reduces Tax Subtotal');
        $I->dontSeeCheckboxIsChecked('Can Combine With Other Coupons');
        $I->seeInField('Start', $startDate);
        $I->seeInField('End', $endDate);

        // Update
        $code = 'TC2';
        $I->fillField('Code', $code);
        $I->click('Save');
        $I->see('Coupon has been saved');
        $I->seeInField('Code', $code);

        // Delete
        $I->click('Delete Coupon');
        $I->see('Success removing coupon');
    }
}
