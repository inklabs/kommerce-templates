<?php

class AdminWarehouseCest
{
    public function accessDeniedViewingWarehouses(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for warehouses');
        $I->amOnPage('/admin/inventory/warehouse');
        $I->seeAdminLoginPage();
    }

    public function crudWarehouse(AcceptanceTester $I)
    {
        $I->wantTo('create/update/delete warehouse');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/inventory/warehouse');
        $I->see('Warehouses', 'h1');

        // Create
        // TODO

        // Update
        // TODO

        // Delete
        // TODO
    }
}
