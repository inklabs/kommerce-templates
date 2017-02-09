<?php

class AdminAttributeCest
{
    public function accessDeniedViewingAttributes(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for attributes');
        $I->amOnPage('/admin/attribute');
        $I->seeAdminLoginPage();
    }

    public function crudAttribute(AcceptanceTester $I)
    {
        $I->wantTo('create/update/delete attribute');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/attribute');
        $I->see('Attributes', 'h1');

        $name = 'Test Attribute';
        $choiceType = 'Image Link';
        $sortOrder = '2';

        // Create
        $I->click('New Attribute');
        $I->see('New Attribute', 'title');
        $I->see('New Attribute', 'h3');
        $I->fillField('Name', $name);
        $I->fillField('Sort Order', $sortOrder);
        $I->selectOption('Choice Type', $choiceType);
        $I->click('Create');
        $I->see('Attribute has been created');
        $I->see($name, 'title');
        $I->seeInField('Name', $name);
        $I->seeInField('Sort Order', $sortOrder);
        $I->seeOptionIsSelected('Choice Type', $choiceType);

        // Update
        $description = 'lorem ipsum';
        $choiceType = 'Select';
        $I->fillField('Description', $description);
        $I->selectOption('Choice Type', $choiceType);
        $I->click('Save');
        $I->see('Attribute has been saved');
        $I->seeInField('Description', $description);
        $I->seeOptionIsSelected('Choice Type', $choiceType);

        // Add Attribute Value
        $skuAV = 'AV1';
        $nameAV = 'Test Attribute Value';
        $descriptionAV = 'lorem ipsum';
        $sortOrderAV = '2';
        $I->click('Attribute Values');
        $I->fillField('Name', $nameAV);
        $I->fillField('SKU', $skuAV);
        $I->fillField('Description', $descriptionAV);
        $I->fillField('Sort Order', $sortOrderAV);
        $I->click('Add');
        $I->see('Successfully created attribute value');
        $I->click('table tr:nth-child(1) .edit-attribute-value');
        $I->seeInField('Name', $nameAV);
        $I->seeInField('SKU', $skuAV);
        $I->seeInField('Description', $descriptionAV);
        $I->seeInField('Sort Order', $sortOrderAV);

        // Update Attribute Value
        $nameAV = 'Renamed Attribute Value';
        $I->fillField('Name', $nameAV);
        $I->click('Save');
        $I->seeInField('Name', $nameAV);

        // Delete Attribute Value
        $I->click('Delete Attribute Value');
        $I->see('Success removing attribute value');

        // Delete
        $I->click('Delete Attribute');
        $I->see('Success removing attribute');
    }
}
