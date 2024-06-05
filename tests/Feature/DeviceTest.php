<?php

namespace Tests\Feature;

use Orchid\Support\Testing\ScreenTesting;
use Tests\Feature\TestFeatureCase;
use App\Models\Device;

class DeviceTest extends TestFeatureCase
{
    use ScreenTesting;
    public function testCreateDevice(): void
    {
        $screen = $this->screen('platform.systems.devices')->actingAs($this->createAdminUser());
        $screen->method('create', [
            'vehicle_id' => 1,
            'name' => 'required',
            'external_id' => 'required',
            'phone_number' => '7000000011',
            'status' => 'required',
            'comment' => 'requred',
            'last_ping_at' => 'null'
             ]);
        $this->assertDatabaseHas('devices', [
           'name' => 'required',
                ]);
    }
    public function testEditDevice(): void
    {
        $screen = $this->screen('platform.systems.devices.edit')->parameters(['device' => Device::where('name', 'required')->first()])->actingAs($this->createAdminUser());
        $screen->method(
            'save',[
           'device' => [
            'vehicle' => 1,
            'name' => 'required',
            'external_id' => 'required',
            'phone_number' => '7000000011',
            'status' => 'required1',
            'comment' => 'requred',
           ],
           ]
        );
        $this->assertDatabaseHas('devices', [
           'status' => 'required1',
                ]);
    }
    public function testRemoveDevice(): void
    {
        $screen = $this->screen('platform.systems.devices.edit')->parameters(['device' => Device::where('name', 'required')->first()])->actingAs($this->createAdminUser());
        $screen->method('remove');
        $this->assertDatabaseCount('devices', 0);

    }
}
