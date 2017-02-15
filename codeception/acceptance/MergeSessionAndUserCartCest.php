<?php

class MergeSessionAndUserCartCest
{
    public function testMerge(AcceptanceTester $I)
    {
        $I->wantTo('ensure merging a user and session cart works');
        $I->loginAsUser();
        $I->addProductToCart();
        $I->click('Sign Out');

        $I->addProductToCart();
        $I->loginAsUser();

        $I->click('Cart');
        $I->see('Total (2 items)');
    }
}
