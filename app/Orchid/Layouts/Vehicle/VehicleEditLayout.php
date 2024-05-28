<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Vehicle;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class VehicleEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('vehicle.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Название ТС'))
                ->placeholder(__('Name')),

            Input::make('vehicle.speed')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Скорость'))
                ->placeholder(__('Name')),
            Input::make('vehicle.number')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Номер ТС'))
                ->placeholder(__('Name')),

            Input::make('vehicle.lat')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Широта'))
                ->placeholder(__('Name')),

            Input::make('vehicle.lng')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Долгота'))
                ->placeholder(__('Name')),
        ];
    }
}
