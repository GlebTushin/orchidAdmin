<?php

namespace Tests\Feature;

use Orchid\Support\Testing\ScreenTesting;
use Tests\Feature\TestFeatureCase;
use App\Models\Vehicle;

class VehicleTest extends TestFeatureCase
{
    use ScreenTesting;
    public function testCreateVehicle(): void
    {
        $screen = $this->screen('platform.systems.vehicles')->actingAs($this->createAdminUser());
        $screen->method('create', [
            'company_id' => 1,
            'name' => 'required',
            'speed' => '100',
            'number' => 'required',
            'lat' => '42',
            'lng' => '120',
             ]);
        $this->assertDatabaseHas('vehicles', [
           'name' => 'required',
                ]);
    }
    public function testEditVehicle(): void
    {
        $screen = $this->screen('platform.systems.vehicles.edit')->parameters(['vehicle' => Vehicle::where('name', 'required')->first()])->actingAs($this->createAdminUser());
        $screen->method(
            'save',[
            'vehicle'=>[
            'company_id' => 1,
            'name' => 'required',
            'speed' => '100',
            'number' => 'required1',
            'lat' => '42',
            'lng' => '120',
            ],]
        );
        $this->assertDatabaseHas('vehicles', [
           'number' => 'required1',
                ]);
    }
    public function testRemoveVehicle(): void
    {
        $screen = $this->screen('platform.systems.vehicles.edit')->parameters(['vehicle' => Vehicle::where('name', 'required')->first()])->actingAs($this->createAdminUser());
        $screen->method('remove');
        $this->assertDatabaseCount('vehicles', 1);

    }
}
