<?php

class AdminCatalogPromtionCest
{
    public function viewAllCatalogPromotions(AcceptanceTester $I)
    {
        $I->wantTo('view all catalog promotions');
        $I->amOnPage('/admin/promotion/catalog-promotion');
        $I->see('Catalog Promotions');
    }
}
