<?php

namespace Tests\Feature;

use Orchid\Support\Testing\ScreenTesting;
use Tests\Feature\TestFeatureCase;
use App\Models\Company;

class CompanyTest extends TestFeatureCase
{
    use ScreenTesting;
    public function testCreateCompany(): void
    {
        $screen = $this->screen('platform.systems.companies')->actingAs($this->createAdminUser());
        $screen->method('create', [
             'company_name' => 'required',
             'lat' => '120',
             'lng' => '42',
             ]);
        $this->assertDatabaseHas('companies', [
           'company_name' => 'required',
                ]);
    }
    public function testEditCompany(): void
    {
        $screen = $this->screen('platform.systems.companies.edit')->parameters(['company' => Company::where('company_name', 'required')->first()])->actingAs($this->createAdminUser());
        $screen->method(
            'save',[
           'company' => [
             'company_name' => 'required1',
             'lat' => '120',
             'lng' => '42',
           ],
           ]
        );
        $this->assertDatabaseHas('companies', [
            'company_name' => 'required1',
                ]);
    }
    public function testRemoveCompany(): void
    {
        $screen = $this->screen('platform.systems.companies.edit')->parameters(['company' => Company::where('company_name', 'required1')->first()])->actingAs($this->createAdminUser());
        $screen->method('remove');
        $this->assertDatabaseMissing('companies', [
            'company_name' => 'required1',
                 ]);

    }
}
