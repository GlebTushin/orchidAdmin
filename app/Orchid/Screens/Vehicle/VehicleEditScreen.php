<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Vehicle;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Vehicle\VehicleEditLayout;

class VehicleEditScreen extends Screen
{
    /**
     * @var Vehicle
     */
    public $vehicle;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Vehicle $vehicle): iterable
    {
        return[
            'vehicle' => $vehicle
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->vehicle->exists ? 'Редактировать ТС' : 'Создать ТС';
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
                ->confirm(__('ТС будет удалено без возможности восстановления'))
                ->method('remove')
                ->canSee($this->vehicle->exists),

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

            Layout::block(VehicleEditLayout::class)
                ->title(__('Редактирование ТС'))
                ->description(__(''))
                ->commands(
                    Button::make(__('Сохранить'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->vehicle->exists)
                        ->method('save')
                ),


        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(vehicle $vehicle, Request $request)
    {
        $request->validate([
            'vehicle_name',
            'company_id',
            'speed' ,
            'number', 
            'lat'  ,
            'lng', 

        ]);
        $vehicle->fill($request->collect('vehicle')->toArray())->save();

        Toast::info(__('vehicle was saved.'));

        return redirect()->route('platform.systems.vehicles');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(vehicle $vehicle)
    {
        $vehicle->delete();

        Toast::info(__('ТС удалено'));

        return redirect()->route('platform.systems.vehicles');
    }


}
