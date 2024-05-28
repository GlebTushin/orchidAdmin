<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Vehicle;

use App\Models\Vehicle;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class VehicleListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'vehicles';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make( __('Компания'))->render(fn($vehicle)=> $vehicle->company->company_name)
            ->sort()
            ->cantHide()
            ->filter(Input::make()),

            TD::make('name', __('Название ТС'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('number', __('Номер ТС'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('speed', __('Скорость'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('lat', __('Широта'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('lng', __('Долгота'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('created_at', __('Создан'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),

            TD::make('updated_at', __('Изменен'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),
               TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Vehicle $vehicle) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Изменить'))
                            ->route('platform.systems.vehicles.edit', $vehicle->vehicle_id)
                            ->icon('bs.pencil'),
                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->confirm(__('Устройство будет удалено'))
                            ->method('remove', [
                                'vehicle_id' => $vehicle->vehicle_id,
                            ]),
                    ])),

        ];
    }
}
