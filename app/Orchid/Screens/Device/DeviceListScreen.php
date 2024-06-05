<?php

namespace App\Orchid\Screens\Device;

use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use App\Models\Device;
use App\Models\Company;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Orchid\Layouts\Device\DeviceListLayout;
use App\Orchid\Layouts\Device\DeviceEditLayout;

class DeviceListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return ['devices' => Device::all(),

    ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Устройства';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавление устройства')->modal('createDevice')->method('create')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            DeviceListLayout::class,
            Layout::modal('createDevice',Layout::rows([
                Select::make('vehicle_id')->fromModel(Vehicle::where('company_id',1),'name'),
                Input::make('name')->required()->title('Название'),
                Input::make('external_id')->required()->title('Номер'),
                Input::make('phone_number')->required()->title('Номер телефона'),
                Input::make('status')->title('Статус'),
                Input::make('comment')->title('Комментарий'),
                Input::make('last_ping_at')->title('Последний раз в сети'),
                ]))->title('Создать устройство')->applyButton('Добавить устройство'),
            Layout::modal('asyncEditDeviceModal', DeviceEditLayout::class)
        ->async('asyncGetDevice'),
        ];
        
    }
public function asyncDevice(Device $device): iterable
    {
        return [
            'device' => $device,
        ];
    }
  public function create(Request $request):void
  { $request->validate([
    'vehicle_id'=> ['required'],
    'name'=> ['required'],
    'external_id'=> ['required'],
    'phone_number'=>['required'],
    'status',
    'comment',
    'last_ping_at',
    ]);
    $createdDevice= new  Device();
    $createdDevice->name = $request->name;
    $createdDevice->vehicle()->associate(Vehicle::findOrFail($request->vehicle_id));
    $createdDevice->company()->associate(Company::findOrFail(Vehicle::findOrFail($request->vehicle_id)->company_id));
    $createdDevice->save();
    Toast::info('Устройство добалено');
  }
  public function remove(Request $request): void
  { 
      Device::findOrFail($request->get('device_id'))->delete();

      Toast::info(__('Device was removed'));
  }
}
