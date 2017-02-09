<?php

class AdminCatalogPromtionCest
{
    public function accessDeniedViewingCatalogPromotions(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for catalog promotions');
        $I->amOnPage('/admin/promotion/catalog-promotion');
        $I->seeAdminLoginPage();
    }

    public function crudCatalogPromotion(AcceptanceTester $I)
    {
        $I->wantTo('create/update/delete catalog promotion');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/promotion/catalog-promotion');
        $I->see('Catalog Promotions', 'h1');

        $name = 'Test CatalogPromotion';
        $discountType = 'Percent';
        $discountValue = '43';
        $maxRedemptions = '100';
        $startDate = '01/01/2017';
        $endDate = '12/31/2017';

        // Create
        $I->click('New Catalog Promotion');
        $I->see('New Catalog Promotion', 'title');
        $I->see('New Catalog Promotion', 'h3');
        $I->fillField('Name', $name);
        $I->selectOption('Discount Type', $discountType);
        $I->fillField('Discount Value', $discountValue);
        $I->fillField('Max Redemptions', $maxRedemptions);
        $I->checkOption('Reduces Tax Subtotal');
        $I->fillField('Start', $startDate);
        $I->fillField('End', $endDate);
        $I->click('Create');
        $I->see('Catalog promotion has been created');
        $I->see($name, 'title');
        $I->seeInField('Name', $name);
        $I->seeOptionIsSelected('Discount Type', $discountType);
        $I->seeInField('Discount Value', $discountValue);
        $I->seeInField('Max Redemptions', $maxRedemptions);
        $I->seeCheckboxIsChecked('Reduces Tax Subtotal');
        $I->seeInField('Start', $startDate);
        $I->seeInField('End', $endDate);

        // Update
        $discountValue = '22';
        $I->fillField('Discount Value', $discountValue);
        $I->click('Save');
        $I->seeInField('Discount Value', $discountValue);

        // Delete
        $I->click('Delete Catalog Promotion');
        $I->see('Success removing catalog promotion');
    }
}
