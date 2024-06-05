<?php

namespace App\Orchid\Screens\Vehicle;

use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use App\Models\Vehicle;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Orchid\Layouts\Vehicle\VehicleListLayout;
use App\Orchid\Layouts\Vehicle\VehicleEditLayout;

class VehicleListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return ['vehicles' => Vehicle::all(),
    ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'список ТС';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавление ТС')->modal('createVehicle')->method('create')
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
            VehicleListLayout::class,
            Layout::modal('createVehicle', Layout::rows([
                Select::make('company_id')->fromModel(Company::class, 'company_name'),
                Input::make('name')->required()->title('Название'),
                Input::make('speed')->required()->title('Скорость'),
                Input::make('number')->required()->title('Номер'),
                Input::make('lat')->required()->title('Широта'),
                Input::make('lng')->required()->title('Долгота'),
                ]))->title('Создать ТС')->applyButton('Добавить ТС'),
            Layout::modal('asyncEditVehicleModal', VehicleEditLayout::class)
        ->async('asyncGetVehicle'),
        ];

    }
    public function asyncVehicle(Vehicle $vehicle): iterable
    {
        return [
            'vehicle' => $vehicle,
        ];
    }
    public function create(Request $request): void
    {
        $request->validate([
          'company_id' => ['required'],
          'name' => ['required'],
          'speed' => ['required'],
          'number' => ['required'],
          'lat' => ['required'],
          'lng' => ['required'],
        ]);
        $createdVehicle = new  Vehicle($request->merge([])->except('_token'));
        $createdVehicle->company()->associate(Company::findOrFail($request->company_id));
        $createdVehicle->save();
        Toast::info(__('ТС добалено'));
    }
    public function remove(Request $request): void
    {
        Vehicle::findOrFail($request->get('vehicle_id'))->delete();

        Toast::info(__('ТС удалено'));
    }
}
