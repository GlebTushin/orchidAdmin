<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Device;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Device\DeviceEditLayout;

class DeviceEditScreen extends Screen
{
    /**
     * @var Device
     */
    public $device;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Device $device): iterable
    {
        return[
            'device' => $device
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->device->exists ? 'Редактировать устройство' : 'Создать устройство';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return '';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Удалить'))
                ->icon('bs.trash3')
                ->confirm(__())
                ->method('remove')
                ->canSee($this->device->exists),

            Button::make(__('Сохранить'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::block(DeviceEditLayout::class)
                ->title(__('Редактирование устройства'))
                ->description(__())
                ->commands(
                    Button::make(__('Сохранить'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->device->exists)
                        ->method('save')
                ),


        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Device $device, Request $request)
    {
        $request->validate([
            'device_name',
            'company_id',
            'vehicle_id',
            'external_id',
            'phone_number',
            'status',
            'comment',
            'last_ping_at',
        ]);

        $device->fill($request->collect('device')->toArray())->save();

        Toast::info(__('Устройство сохранено.'));

        return redirect()->route('platform.systems.devices');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Device $device)
    {
        $device->delete();

        Toast::info(__('Устройство было удалено'));

        return redirect()->route('platform.systems.devices');
    }


}
