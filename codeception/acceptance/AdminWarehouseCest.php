<?php

class AdminWarehouseCest
{
    public function accessDeniedViewingWarehouses(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for warehouses');
        $I->amOnPage('/admin/warehouse');
        $I->seeAdminLoginPage();
    }

    public function crudWarehouse(AcceptanceTester $I)
    {
        $I->wantTo('create/update/delete warehouse');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/warehouse');
        $I->see('Warehouses', 'h1');

        $name = 'Warehouse 1';
        $attention = 'Shipping Dept';
        $company = 'Acme Ltd';
        $address1 = '123 Any';
        $address2 = 'Ste 3';
        $city = 'Santa Monica';
        $state = 'CA';
        $zip5 = '90210';
        $zip4 = '6808';
        $latitude = '34.052234';
        $longitude = '-118.243685';

        // Create
        $I->click('New Warehouse');
        $I->see('New Warehouse', 'title');
        $I->see('New Warehouse', 'h3');
        $I->fillField('Name', $name);
        $I->fillField('Attention', $attention);
        $I->fillField('Company', $company);
        $I->fillField('Address 1', $address1);
        $I->fillField('Address 2', $address2);
        $I->fillField('City', $city);
        $I->fillField('State', $state);
        $I->fillField('Zip5', $zip5);
        $I->fillField('Zip4', $zip4);
        $I->fillField('Latitude', $latitude);
        $I->fillField('Longitude', $longitude);
        $I->click('Create');
        $I->see('Warehouse has been created');
        $I->see($name, 'title');
        $I->seeInField('Name', $name);
        $I->seeInField('Attention', $attention);
        $I->seeInField('Company', $company);
        $I->seeInField('Address 1', $address1);
        $I->seeInField('Address 2', $address2);
        $I->seeInField('City', $city);
        $I->seeInField('State', $state);
        $I->seeInField('Zip5', $zip5);
        $I->seeInField('Zip4', $zip4);
        $I->seeInField('Latitude', $latitude);
        $I->seeInField('Longitude', $longitude);

        // Update
        $name = 'Warehouse 1a';
        $I->fillField('Name', $name);
        $I->click('Save');
        $I->see('Warehouse has been saved');
        $I->seeInField('Name', $name);

        // Delete
        $I->click('Delete Warehouse');
        $I->see('Success removing warehouse');
    }
}
