<?php

use inklabs\kommerce\Lib\Uuid;

class AdminTagCest
{
    public function accessDeniedViewingTags(AcceptanceTester $I)
    {
        $I->wantTo('ensure admin-only access for tags');
        $I->amOnPage('/admin/tag');
        $I->seeAdminLoginPage();
    }

    public function crudTag(AcceptanceTester $I)
    {
        $I->wantTo('create/update/delete tag');
        $I->loginAsAdmin();
        $I->amOnPage('/admin/tag');
        $I->see('Tags', 'h1');

        $name = 'Test Tag';
        $code = 'TC-' . Uuid::uuid4();

        // Create
        $I->click('New Tag');
        $I->see('New Tag', 'title');
        $I->see('New Tag', 'h3');
        $I->fillField('Name', $name);
        $I->checkOption('Is Active');
        $I->checkOption('Is Visible');
        $I->fillField('Code', $code);
        $I->click('Create');
        $I->see('Tag has been created');
        $I->see($name, 'title');
        $I->seeInField('Name', $name);
        $I->seeCheckboxIsChecked('Is Active');
        $I->seeCheckboxIsChecked('Is Visible');
        $I->seeInField('Code', $code);
        $I->dontSeeCheckboxIsChecked('Are Attachments Enabled');

        // Update
        $description = 'lorem ipsum';
        $I->fillField('Description', $description);
        $I->click('Save');
        $I->see('Tag has been saved');
        $I->seeInField('Description', $description);

        // Delete
        $I->click('Delete Tag');
        $I->see('Success removing tag');
    }
}
